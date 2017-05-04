<?php
/**
 * Created by PhpStorm.
 * User: Nikolas
 * Date: 15.03.2017
 * Time: 23:40
 */

namespace InterfaceBundle\Controller;


use ApiBundle\Controller\SenderController;
use ApiBundle\Helper\Sender;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use GuzzleHttp\Psr7;

class DeviceReaderController extends Controller
{

    public function indexAction(Request $request){

        $me = $this->getUser();
        $sections = $me->getSections();
        $data = [];
        $i = 0;

        if ($request->getMethod() == Request::METHOD_POST && $request->request->get('query') != null )
        {
            $filter = [
                'query' => $request->request->get('query'),
            ];

            while (!empty($sections[$i])){
                $pom = $this->getDoctrine()->getRepository("CoreBundle:DeviceReader")->findAllReadersBySection($sections[$i]->getId(), $filter);
                $a = 0;
                while (!empty($pom[$a])){

                    array_push($data, $pom[$a]);
                    $a ++;
                }
                $i ++;
            }
        }
        else
        {
            while (!empty($sections[$i])){
                $pom = $this->getDoctrine()->getRepository("CoreBundle:DeviceReader")->findBy([
                    'sectionId' => $sections[$i]->getId()
                ]);
                $a = 0;
                while (!empty($pom[$a])){
                    array_push($data, $pom[$a]);
                    $a ++;
                }
                $i ++;
            }
        }
//        var_dump($data[0]->getName());

        return $this->render('InterfaceBundle:ReaderDevice:main.html.twig', [
            'nfcReaders' => $data
        ]);
    }

    public function viewNfcReaderAction($id_reader){


        $reader = $this->getDoctrine()->getRepository("CoreBundle:DeviceReader")->find($id_reader);

//        $this->get('service_name_sender')->sendPost($reader, $reader->getSection(), null , null);


        return $this->render('@Interface/ReaderDevice/viewReader.html.twig', [
            'deviceReader' => $reader,
            'pom_error' => 0
        ]);

    }

    public function updateNfcReaderAction($id_reader){

        $reader = $this->getDoctrine()->getRepository("CoreBundle:DeviceReader")->find($id_reader);

        $section = $reader->getSection();

        $users = $section->getUsers();
        $i = 0;

        while (!empty($users[$i])){
            $allow_from_1 = [];
            $allow_to_1 = [];
            $deny_from_1 = [];
            $deny_to_1 = [];
            $allow_from_2 = [];
            $allow_to_2 = [];
            $deny_from_2 = [];
            $deny_to_2 = [];


            $concreteProfile = $this->getDoctrine()->getRepository("CoreBundle:Profile")->findOneProfile($section->getId(), $users[$i]->getId());

            $entries = $this->getDoctrine()->getRepository("CoreBundle:Entry")->findBy([
                'userId' => $users[$i]->getId(),
                'sectionId' => $section->getId()
            ]);

            $a = 0;

            while(!empty($entries[$a])){
                $from = "";
                $to = "";

                $from = $from. $entries[$a]->getFromMinutes()." ". $entries[$a]->getFromHours();
                $to = $to. $entries[$a]->getUntilMinutes()." ". $entries[$a]->getUntilHours();

                if($entries[$a]->getDayOfMonth() != null){
                    $from = $from." ".$entries[$a]->getDayOfMonth();
                    $to = $to." ".$entries[$a]->getDayOfMonth();
                }else{
                    $from = $from. " *";
                    $to = $to. " *";
                }

                if($entries[$a]->getMonth() != null){
                    $from = $from." ".$entries[$a]->getMonth();
                    $to = $to." ".$entries[$a]->getMonth();
                }else{
                    $from = $from. " *";
                    $to = $to. " *";
                }

                if($entries[$a]->getDayOfWeek() != null){
                    $from = $from." ".$entries[$a]->getDayOfWeek();
                    $to = $to." ".$entries[$a]->getDayOfWeek();
                }else{
                    $from = $from. " *";
                    $to = $to. " *";
                }
                if($entries[$a]->getYear() != null){
                    $from = $from." ".$entries[$a]->getYear();
                    $to = $to." ".$entries[$a]->getYear();
                }else{
                    $from = $from." *";
                    $to = $to." *";
                }

                if($entries[$a]->getIsActive() == 0){
                    array_push($deny_from_1, $from );
                    array_push($deny_to_1, $to );
                }else{
                    array_push($allow_from_1, $from );
                    array_push($allow_to_1, $to );
                }
                $a ++;
            }


            if(!empty($concreteProfile)){

                $entries2 = $concreteProfile[0]->getEntrys();

                $a = 0;

                while(!empty($entries2[$a])){
                    $from = "";
                    $to = "";

                    $from = $from. $entries2[$a]->getFromMinutes()." ". $entries2[$a]->getFromHours();
                    $to = $to. $entries2[$a]->getUntilMinutes()." ". $entries2[$a]->getUntilHours();

                    if($entries2[$a]->getDayOfMonth() != null){
                        $from = $from." ". $entries2[$a]->getDayOfMonth();
                        $to = $to." ". $entries2[$a]->getDayOfMonth();
                    }else{
                        $from = $from. " *";
                        $to = $to. " *";
                    }

                    if($entries2[$a]->getMonth() != null){
                        $from = $from." ". $entries2[$a]->getMonth();
                        $to = $to." ". $entries2[$a]->getMonth();
                    }else{
                        $from = $from. " *";
                        $to = $to. " *";
                    }

                    if($entries2[$a]->getDayOfWeek() != null){
                        $from = $from." ". $entries2[$a]->getDayOfWeek();
                        $to = $to." ". $entries2[$a]->getDayOfWeek();
                    }else{
                        $from = $from. " *";
                        $to = $to. " *";
                    }
                    if($entries2[$a]->getYear() != null){
                        $from = $from." ". $entries2[$a]->getYear();
                        $to = $to." ". $entries2[$a]->getYear();
                    }else{
                        $from = $from." *";
                        $to = $to." *";
                    }

                    if($entries2[$a]->getIsActive() == 0){
                        array_push($deny_from_2, $from );
                        array_push($deny_to_2, $to );
                    }else{
                        array_push($allow_from_2, $from );
                        array_push($allow_to_2, $to );
                    }
                    $a ++;
                }
            }



            $mobiledevices = $users[$i]->getDevices();

            $b = 0;

            while (!empty($mobiledevices[$b])){

                $data = [
                    "device_uuid" => $reader->getUuid(),
                    "username" => $users[$i]->getUsername(),
                    "uuid" => $mobiledevices[$b]->getUuid(),
                    "private_key" => "private_key",
                    "public_key" => $mobiledevices[$b]->getPrivateKey(),
                    "permissions" => [
                        "allow_priority_1" => [
                            "from" => $allow_from_1,
                            "to" => $allow_to_1,
                        ],
                        "deny_priority_1" => [
                            "from" => $deny_from_1,
                            "to" => $deny_to_1,
                        ],
                        "allow_priority_2" => [
                            "from" => $allow_from_2,
                            "to" => $allow_to_2,
                        ],
                        "deny_priority_2" => [
                            "from" => $deny_from_2,
                            "to" => $deny_to_2,
                        ]


                    ]
                ];

                $client = new Client(['verify' => false]);
                try {
                    $client->request('POST', $reader->getIpAddress(),

                        ['json' => $data]
                    );
                } catch (ConnectException $e) {
                    var_dump( Psr7\str($e->getRequest()) );
//                    echo Psr7\str($e->getRequest());
                    var_dump("----------------------------------------------------------------");
//                    var_dump( Psr7\str($e->getResponse()) );
                    if($e->getResponse() == null){
                        return $this->render('@Interface/ReaderDevice/viewReader.html.twig', [
                            'deviceReader' => $reader,
                            'pom_error' => "Nepodarilo sa aktualizovat"
                        ]);

                    }

                }


                $b ++;


            }

            $i ++;

        }

        return $this->render('@Interface/ReaderDevice/viewReader.html.twig', [
            'deviceReader' => $reader,
            'pom_error' => 0
        ]);
    }

    public function updateOfflineReaderAction($id_reader)
    {

        $tmp_dir = sprintf("%s/../var/tmp", $this->get('kernel')->getRootDir());

        if (!is_dir($tmp_dir))
        {
            mkdir($tmp_dir, 0777);
        }

        $session_name = uniqid("offline_");

        $session_dir = sprintf("%s/%s", $tmp_dir, $session_name);
        $files = [];

        if (!is_dir($session_dir))
        {
            mkdir($session_dir, 0777);
        }

        //------------------------------------------------

        $reader = $this->getDoctrine()->getRepository("CoreBundle:DeviceReader")->find($id_reader);

        $section = $reader->getSection();

        $users = $section->getUsers();
        $i = 0;

        while (!empty($users[$i])){
            $allow_from_1 = [];
            $allow_to_1 = [];
            $deny_from_1 = [];
            $deny_to_1 = [];
            $allow_from_2 = [];
            $allow_to_2 = [];
            $deny_from_2 = [];
            $deny_to_2 = [];


            $concreteProfile = $this->getDoctrine()->getRepository("CoreBundle:Profile")->findOneProfile($section->getId(), $users[$i]->getId());

            $entries = $this->getDoctrine()->getRepository("CoreBundle:Entry")->findBy([
                'userId' => $users[$i]->getId(),
                'sectionId' => $section->getId()
            ]);

            $a = 0;

            while(!empty($entries[$a])){
                $from = "";
                $to = "";

                $from = $from. $entries[$a]->getFromMinutes()." ". $entries[$a]->getFromHours();
                $to = $to. $entries[$a]->getUntilMinutes()." ". $entries[$a]->getUntilHours();

                if($entries[$a]->getDayOfMonth() != null){
                    $from = $from." ".$entries[$a]->getDayOfMonth();
                    $to = $to." ".$entries[$a]->getDayOfMonth();
                }else{
                    $from = $from. " *";
                    $to = $to. " *";
                }

                if($entries[$a]->getMonth() != null){
                    $from = $from." ".$entries[$a]->getMonth();
                    $to = $to." ".$entries[$a]->getMonth();
                }else{
                    $from = $from. " *";
                    $to = $to. " *";
                }

                if($entries[$a]->getDayOfWeek() != null){
                    $from = $from." ".$entries[$a]->getDayOfWeek();
                    $to = $to." ".$entries[$a]->getDayOfWeek();
                }else{
                    $from = $from. " *";
                    $to = $to. " *";
                }
                if($entries[$a]->getYear() != null){
                    $from = $from." ".$entries[$a]->getYear();
                    $to = $to." ".$entries[$a]->getYear();
                }else{
                    $from = $from." *";
                    $to = $to." *";
                }

                if($entries[$a]->getIsActive() == 0){
                    array_push($deny_from_1, $from );
                    array_push($deny_to_1, $to );
                }else{
                    array_push($allow_from_1, $from );
                    array_push($allow_to_1, $to );
                }
                $a ++;
            }


            if(!empty($concreteProfile)){

                $entries2 = $concreteProfile[0]->getEntrys();

                $a = 0;

                while(!empty($entries2[$a])){
                    $from = "";
                    $to = "";

                    $from = $from. $entries2[$a]->getFromMinutes()." ". $entries2[$a]->getFromHours();
                    $to = $to. $entries2[$a]->getUntilMinutes()." ". $entries2[$a]->getUntilHours();

                    if($entries2[$a]->getDayOfMonth() != null){
                        $from = $from." ". $entries2[$a]->getDayOfMonth();
                        $to = $to." ". $entries2[$a]->getDayOfMonth();
                    }else{
                        $from = $from. " *";
                        $to = $to. " *";
                    }

                    if($entries2[$a]->getMonth() != null){
                        $from = $from." ". $entries2[$a]->getMonth();
                        $to = $to." ". $entries2[$a]->getMonth();
                    }else{
                        $from = $from. " *";
                        $to = $to. " *";
                    }

                    if($entries2[$a]->getDayOfWeek() != null){
                        $from = $from." ". $entries2[$a]->getDayOfWeek();
                        $to = $to." ". $entries2[$a]->getDayOfWeek();
                    }else{
                        $from = $from. " *";
                        $to = $to. " *";
                    }
                    if($entries2[$a]->getYear() != null){
                        $from = $from." ". $entries2[$a]->getYear();
                        $to = $to." ". $entries2[$a]->getYear();
                    }else{
                        $from = $from." *";
                        $to = $to." *";
                    }

                    if($entries2[$a]->getIsActive() == 0){
                        array_push($deny_from_2, $from );
                        array_push($deny_to_2, $to );
                    }else{
                        array_push($allow_from_2, $from );
                        array_push($allow_to_2, $to );
                    }
                    $a ++;
                }
            }



            $mobiledevices = $users[$i]->getDevices();

            $b = 0;

            while (!empty($mobiledevices[$b])){

                $data = [
                    "device_uuid" => $reader->getUuid(),
                    "username" => $users[$i]->getUsername(),
                    "uuid" => $mobiledevices[$b]->getUuid(),
                    "private_key" => "private_key",
                    "public_key" => $mobiledevices[$b]->getPrivateKey(),
                    "permissions" => [
                        "allow_priority_1" => [
                            "from" => $allow_from_1,
                            "to" => $allow_to_1,
                        ],
                        "deny_priority_1" => [
                            "from" => $deny_from_1,
                            "to" => $deny_to_1,
                        ],
                        "allow_priority_2" => [
                            "from" => $allow_from_2,
                            "to" => $allow_to_2,
                        ],
                        "deny_priority_2" => [
                            "from" => $deny_from_2,
                            "to" => $deny_to_2,
                        ]


                    ]
                ];


                $filename = sprintf("%s.txt", $mobiledevices[$b]->getUuid());
                file_put_contents(sprintf("%s/%s", $session_dir, $filename), json_encode($data));
                $files[] = sprintf("%s/%s", $session_dir, $filename);



                $b ++;


            }

            $i ++;

        }

        //------------------------------------------------
//        for ($i = 0; $i < 4; $i++)
//        {
//            $array = [
//                "key" => $i
//            ];
//            $filename = sprintf("%s.txt", uniqid($i));
//            file_put_contents(sprintf("%s/%s", $session_dir, $filename), json_encode($array));
//            $files[] = sprintf("%s/%s", $session_dir, $filename);
//        }

        $archive_path = sprintf("%s/%s.zip", $tmp_dir, $session_name);

        $zip = new \ZipArchive();

        $handle = $zip->open($archive_path, \ZipArchive::CREATE);

        if (!$handle) {
            // zle je
        }

        foreach ($files as $file)
        {
            $zip->addFile($file, basename($file));
        }

        $zip->close();

        $response = new BinaryFileResponse($archive_path);
        $response->setContentDisposition('attachment', $session_name . '.zip');

        return $response;
    }



}