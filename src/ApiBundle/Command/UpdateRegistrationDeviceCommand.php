<?php
/**
 * Created by PhpStorm.
 * User: Nikolas
 * Date: 03.05.2017
 * Time: 18:42
 */

namespace ApiBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateRegistrationDeviceCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('api:update_terminals')
            ->setDescription('Update terminals')
            ->setHelp('Update terminals for user....')
            ->addArgument('Deviceuuid', InputArgument::REQUIRED, 'Uuid of device');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $uuid = $input->getArgument('Deviceuuid');

        $em = $this->getContainer()->get('doctrine.orm.default_entity_manager');

        $device = $em->getRepository("CoreBundle:DeviceReader")->findBy([
            'uuid' => $uuid
        ]);

        $output->writeln("Test");


    }


}