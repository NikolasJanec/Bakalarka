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

        $me = $this->getUser();
        $sections = $me->getSections();
        $logs = [];
        $i = 0;
        while (!empty($sections[$i])){
            $pom = $this->getDoctrine()->getRepository("CoreBundle:Log")->findBy([
                'sectionId' => $sections[$i]->getId()
            ]);
            $a = 0;
            while (!empty($pom[$a])){
                array_push($logs, $pom[$a]);
                $a ++;
            }

            $i ++;
        }

        return $this->render('@Interface/Logs/viewLogs.html.twig', array(
            'logs' => $logs,
            'sections' => $sections,
        ));
    }

    public function viewLogsInSectionAction($id_section)
    {
        $logs = $this->getDoctrine()->getRepository("CoreBundle:Log")->findBy([
            'sectionId' =>$id_section
        ]);

        $me = $this->getUser();

        $sections = $me->getSections();

        return $this->render('@Interface/Logs/viewLogs.html.twig', array(
            'logs' => $logs,
            'sections' => $sections,
        ));
    }




}