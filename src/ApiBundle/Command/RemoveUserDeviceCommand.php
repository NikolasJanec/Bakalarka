<?php
/**
 * Created by PhpStorm.
 * User: Nikolas
 * Date: 05.05.2017
 * Time: 9:01
 */

namespace ApiBundle\Command;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RemoveUserDeviceCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('api:remove_device')
            ->setDescription('Remove Device')
            ->setHelp('Remove device in sections....')
            ->addArgument('DeviceId', InputArgument::REQUIRED, 'Id of user device');


    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine.orm.default_entity_manager');
        $device_id = $input->getArgument('DeviceId');
        $device = $em->getRepository("CoreBundle:Device")->find($device_id);
        $user = $device->getUser();
        $sections = $user->getSections();

        $i = 0;

        while (!empty($sections[$i])) {


            $readers = $sections[$i]->getDeviceReaders();
            $b = 0;
            while (!empty($readers[$b])) {

                $type = $readers[$b]->getTypeReader();

                if($type->getCode() == "HYBRID")
                {

                    $data = [
                        "device_uuid" => $readers[$b]->getUuid(),
                        "uuid" => $device->getUuid(),

                    ];

                    $client = new Client(['verify' => false, 'http_errors' => false]);
                    try {

                        $url= "https://".$readers[$b]->getIpAddress().":".$readers[$b]->getPortNumber()."/v1/delete";
                        //                    $url = "http://192.168.56.10:3000/posts";

                        $client->request('POST', $url,

                            ['json' => $data]
                        );
                    } catch (ConnectException $e) {

                    }


                }
                $b ++;

            }
            $i ++;

        }


    }

}