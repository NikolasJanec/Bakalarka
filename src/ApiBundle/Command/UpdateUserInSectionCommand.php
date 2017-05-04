<?php
/**
 * Created by PhpStorm.
 * User: Nikolas
 * Date: 04.05.2017
 * Time: 19:19
 */

namespace ApiBundle\Command;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateUserInSectionCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('api:update_user')
            ->setDescription('Update user')
            ->setHelp('Update user in sections....')
            ->addArgument('UserId', InputArgument::REQUIRED, 'Id of user')
            ->addArgument('SectionId', InputArgument::REQUIRED, 'Id of section');

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $user_id = $input->getArgument('UserId');
        $section_id = $input->getArgument('SectionId');


        $em = $this->getContainer()->get('doctrine.orm.default_entity_manager');


        $user = $em->getRepository("CoreBundle:User")->find($user_id);
        $devices = $user->getDevices();

        $sections = null;

        if($section_id == 0){
            $sections = $user->getSections();

        }else{
            $sections = $em->getRepository("CoreBundle:Section")->findBy([
                'id' => $section_id
            ]);

        }

        $i = 0;

        while (!empty($sections[$i])) {

            $allow_from_1 = [];
            $allow_to_1 = [];
            $deny_from_1 = [];
            $deny_to_1 = [];
            $allow_from_2 = [];
            $allow_to_2 = [];
            $deny_from_2 = [];
            $deny_to_2 = [];

            $concreteProfile = $em->getRepository("CoreBundle:Profile")->findOneProfile($sections[$i]->getId(), $user->getId());

            $entries = $em->getRepository("CoreBundle:Entry")->findBy([
                'userId' => $user->getId(),
                'sectionId' => $sections[$i]->getId()
            ]);

            $a = 0;

            while (!empty($entries[$a])) {
                $from = "";
                $to = "";

                $from = $from . $entries[$a]->getFromMinutes() . " " . $entries[$a]->getFromHours();
                $to = $to . $entries[$a]->getUntilMinutes() . " " . $entries[$a]->getUntilHours();

                if ($entries[$a]->getDayOfMonth() != null) {
                    $from = $from . " " . $entries[$a]->getDayOfMonth();
                    $to = $to . " " . $entries[$a]->getDayOfMonth();
                } else {
                    $from = $from . " *";
                    $to = $to . " *";
                }

                if ($entries[$a]->getMonth() != null) {
                    $from = $from . " " . $entries[$a]->getMonth();
                    $to = $to . " " . $entries[$a]->getMonth();
                } else {
                    $from = $from . " *";
                    $to = $to . " *";
                }

                if ($entries[$a]->getDayOfWeek() != null) {
                    $from = $from . " " . $entries[$a]->getDayOfWeek();
                    $to = $to . " " . $entries[$a]->getDayOfWeek();
                } else {
                    $from = $from . " *";
                    $to = $to . " *";
                }
                if ($entries[$a]->getYear() != null) {
                    $from = $from . " " . $entries[$a]->getYear();
                    $to = $to . " " . $entries[$a]->getYear();
                } else {
                    $from = $from . " *";
                    $to = $to . " *";
                }

                if ($entries[$a]->getIsActive() == 0) {
                    array_push($deny_from_1, $from);
                    array_push($deny_to_1, $to);
                } else {
                    array_push($allow_from_1, $from);
                    array_push($allow_to_1, $to);
                }
                $a++;
            }

            if (!empty($concreteProfile)) {

                $entries2 = $concreteProfile[0]->getEntrys();

                $a = 0;

                while (!empty($entries2[$a])) {
                    $from = "";
                    $to = "";

                    $from = $from . $entries2[$a]->getFromMinutes() . " " . $entries2[$a]->getFromHours();
                    $to = $to . $entries2[$a]->getUntilMinutes() . " " . $entries2[$a]->getUntilHours();

                    if ($entries2[$a]->getDayOfMonth() != null) {
                        $from = $from . " " . $entries2[$a]->getDayOfMonth();
                        $to = $to . " " . $entries2[$a]->getDayOfMonth();
                    } else {
                        $from = $from . " *";
                        $to = $to . " *";
                    }

                    if ($entries2[$a]->getMonth() != null) {
                        $from = $from . " " . $entries2[$a]->getMonth();
                        $to = $to . " " . $entries2[$a]->getMonth();
                    } else {
                        $from = $from . " *";
                        $to = $to . " *";
                    }

                    if ($entries2[$a]->getDayOfWeek() != null) {
                        $from = $from . " " . $entries2[$a]->getDayOfWeek();
                        $to = $to . " " . $entries2[$a]->getDayOfWeek();
                    } else {
                        $from = $from . " *";
                        $to = $to . " *";
                    }
                    if ($entries2[$a]->getYear() != null) {
                        $from = $from . " " . $entries2[$a]->getYear();
                        $to = $to . " " . $entries2[$a]->getYear();
                    } else {
                        $from = $from . " *";
                        $to = $to . " *";
                    }

                    if ($entries2[$a]->getIsActive() == 0) {
                        array_push($deny_from_2, $from);
                        array_push($deny_to_2, $to);
                    } else {
                        array_push($allow_from_2, $from);
                        array_push($allow_to_2, $to);
                    }
                    $a++;
                }
            }

            $readers = $sections[$i]->getDeviceReaders();
            $b = 0;
            while (!empty($readers[$b])) {

                $type = $readers[$b]->getTypeReader();

                if($type->getCode() == "HYBRID")
                {
                    $c = 0;

                    while(!empty($devices[$c])){

                        $data = [
                            "device_uuid" => $readers[$b]->getUuid(),
                            "username" => $user->getUsername(),
                            "uuid" => $devices[$c]->getUuid(),
                            "private_key" => "private_key",
                            "public_key" => $devices[$c]->getPrivateKey(),
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
                            $client->request('POST', $readers[$b]->getIpAddress(),

                                ['json' => $data]
                            );
                        } catch (ConnectException $e) {

                        }

                        $c ++;

                    }




                }
                $b ++;

            }
            $i ++;

        }


    }

}