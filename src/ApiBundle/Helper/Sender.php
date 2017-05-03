<?php
/**
 * Created by PhpStorm.
 * User: Nikolas
 * Date: 27.04.2017
 * Time: 9:48
 */

namespace ApiBundle\Helper;


use GuzzleHttp\Client;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Templating\EngineInterface;

class Sender extends Controller
{

//    private $service_container;
//
//    public function __construct(EngineInterface $service_container)
//    {
//        $this->service_container = $service_container;
//    }

    public function sendPost($NFCReader, $section , $user , $device ){

        if(!empty($NFCReader) && !empty($section) && empty($user) && empty($device) ){

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

                   $from = $from. $entries[$a]->getFromMinutes(). $entries[$a]->getFromHours();
                   $to = $to. $entries[$a]->getUntilMinutes(). $entries[$a]->getUntilHours();

                   if($entries[$a]->getDayOfMonth() != null){
                       $from = $from.$entries[$a]->getDayOfMonth();
                       $to = $to.$entries[$a]->getDayOfMonth();
                   }else{
                       $from = $from. "*";
                       $to = $to. "*";
                   }

                   if($entries[$a]->getMonth() != null){
                       $from = $from.$entries[$a]->getMonth();
                       $to = $to.$entries[$a]->getMonth();
                   }else{
                       $from = $from. "*";
                       $to = $to. "*";
                   }

                   if($entries[$a]->getDayOfWeek() != null){
                       $from = $from.$entries[$a]->getDayOfWeek();
                       $to = $to.$entries[$a]->getDayOfWeek();
                   }else{
                       $from = $from. "*";
                       $to = $to. "*";
                   }
                   if($entries[$a]->getYear() != null){
                       $from = $from.$entries[$a]->getYear();
                       $to = $to.$entries[$a]->getYear();
                   }else{
                       $from = $from." ";
                       $to = $to." ";
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

                       $from = $from. $entries2[$a]->getFromMinutes(). $entries2[$a]->getFromHours();
                       $to = $to. $entries2[$a]->getUntilMinutes(). $entries2[$a]->getUntilHours();

                       if($entries2[$a]->getDayOfMonth() != null){
                           $from = $from.$entries2[$a]->getDayOfMonth();
                           $to = $to.$entries2[$a]->getDayOfMonth();
                       }else{
                           $from = $from. "*";
                           $to = $to. "*";
                       }

                       if($entries2[$a]->getMonth() != null){
                           $from = $from.$entries2[$a]->getMonth();
                           $to = $to.$entries2[$a]->getMonth();
                       }else{
                           $from = $from. "*";
                           $to = $to. "*";
                       }

                       if($entries2[$a]->getDayOfWeek() != null){
                           $from = $from.$entries2[$a]->getDayOfWeek();
                           $to = $to.$entries2[$a]->getDayOfWeek();
                       }else{
                           $from = $from. "*";
                           $to = $to. "*";
                       }
                       if($entries2[$a]->getYear() != null){
                           $from = $from.$entries2[$a]->getYear();
                           $to = $to.$entries2[$a]->getYear();
                       }else{
                           $from = $from." ";
                           $to = $to." ";
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

               $i ++;

               $mobiledevices = $user->getDevices();

               $b = 0;

               while (!empty($mobiledevices[$b])){

                   $data = [
                       "device_uuid" => $NFCReader->getUuid(),
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
                   $client->request('POST', 'http://192.168.56.1:3000/posts',

                       ['json' => $data]
                   );

                   $b ++;

               }



           }

        }


//        $client = new Client(['verify' => false]);
//
//        $data = [
//            "device_uuid" => "C7C89278-678E-4D2D-B645-66F595E898E2",
//            "username" => "username",
//            "uuid" => "uuid-mobil",
//            "private_key" => "private_key",
//            "public_key" => "public_key",
//            "permissions" => [
//                "allow_priority_1" => [
//                    "from" => [],
//                    "to" => [],
//                ],
//                "deny_priority_1" => [
//                    "from" => ["20 5 * * *", "30 18 * * *"],
//                    "to" => ["40 6 * * *", "0 19 * * *" ],
//                ],
//                "allow_priority_2" => [
//                    "from" => ["30 4 * * *", "50 18 * * *"],
//                    "to" => ["20 18 * * *", "0 21 * * *" ],
//                ],
//                "deny_priority_2" => [
//                    "from" => ["20 5 * * *", "30 18 * * *"],
//                    "to" => ["40 6 * * *", "0 19 * * *" ],
//                ]
//
//
//            ]
//        ];
//
//
//
//
//        $client->request('POST', 'http://192.168.56.1:3000/posts',
////        $client->request('POST', 'https://192.168.0.10:7778/v1/add_or_update',
//       //$promise =  $client->postAsync('http://192.168.56.1:3000/posts',
//        ['json' => $data]
//        );
//

     }







}
