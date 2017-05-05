<?php
/**
 * Created by PhpStorm.
 * User: Nikolas
 * Date: 02.05.2017
 * Time: 1:29
 */

namespace InterfaceBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LogController extends Controller
{

    public function viewLogsAction(){

        $logs = $this->getDoctrine()->getRepository("CoreBundle:Log")->findAll();

        $me = $this->getUser();

        $sections = $me->getSections();

        return $this->render('@Interface/Logs/viewLogs.html.twig', array(
            'logs' => $logs,
            'sections' => $sections,
            'thisSection' => 0
        ));
    }




}