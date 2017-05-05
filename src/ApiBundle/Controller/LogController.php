<?php
/**
 * Created by PhpStorm.
 * User: Nikolas
 * Date: 05.05.2017
 * Time: 17:48
 */

namespace ApiBundle\Controller;


use CoreBundle\Entity\Log;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LogController extends Controller
{

    public function  createAction(Request $request, $id){

        $log = new Log();
        $data = json_decode($request->getContent(),true);

        if (!empty($data)){

            $terminal = $this->getDoctrine()->getRepository("CoreBundle:DeviceReader")->find($id);

            if (!empty($terminal) && $terminal->getUuid() == $data['uuid_terminal']){

                $device = $this->getDoctrine()->getRepository("CoreBundle:Device")->findOneBy([
                    'uuid' => $data['uuid_device']
                ]);

                if(!empty($device)){
                    $log->setDevice($device);
                    $log->setUser($device->getUser());
                    $log->setDeviceReader($terminal);
                    $log->setSection($terminal->getSection());
                    $log->fillCreatedAt();
                    $log->fillUpdatedAt();
                    $log->setStatus($data['status']);
                    $log->setActivity("Prístup");
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($log);
                    $em->flush();


                    return new  JsonResponse('OK',Response::HTTP_OK);
                }else{
                    return new  JsonResponse('Bad device',Response::HTTP_BAD_REQUEST);
                }
            }

            else{
                return new  JsonResponse('Bad terminal',Response::HTTP_BAD_REQUEST);
            }
        }
        else{
            return new  JsonResponse('Empty/Wrong json',Response::HTTP_BAD_REQUEST);
        }

    }


}