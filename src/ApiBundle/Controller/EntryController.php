<?php
/**
 * Created by PhpStorm.
 * User: Nikolas
 * Date: 29.03.2017
 * Time: 21:56
 */

namespace ApiBundle\Controller;



use CoreBundle\Entity\Log;
use CoreBundle\Entity\Profile;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Validator\Constraints\DateTime;

class EntryController extends Controller
{
    public function  checkAction(Request $request, $id){

        $log = new Log();
        $data = json_decode($request->getContent(),true);

        if (!empty($data)){

            $terminal = $this->getDoctrine()->getRepository("CoreBundle:DeviceReader")->find($id);

            if (!empty($terminal) && $terminal->getUuid() == $data['uuid']){

                $device = $this->getDoctrine()->getRepository("CoreBundle:Device")->findOneBy([
                    'uuid' => $data['uuid_device']
                ]);

                if(!empty($device)){
                    $user = $device->getUser();


                    $section = $this->getDoctrine()->getRepository("CoreBundle:Section")->find($terminal->getSectionId());
//                    $section = $terminal->getSection();


                    /**
                     * @param Profile $userHaveSection
                     */
                    $userHaveSection = $this->getDoctrine()->getRepository("CoreBundle:Section")->findSection($user->getId(), $section->getId());
                    //echo($userHaveSection[0]);
                    if($userHaveSection[0]->getId() == $section->getId()){
                        $entries1 = $this->getDoctrine()->getRepository("CoreBundle:Entry")->findBy([
                            'userId' => $user->getId(),
                            'sectionId' => $section->getId()
                        ]);

                        $i = 0;
                        $status = false;
                        $publickey = null;
                        $p1 = "bbb";
                        while (!empty($entries1[$i])){
                            if ($entries1[$i]->getYear() == date('Y') || $entries1[$i]->getYear() == null){
                                if ($entries1[$i]->getMonth() == date('m') || $entries1[$i]->getDayOfMonth() == null ){
                                    if ($entries1[$i]->getDayOfMonth() == date('t') || $entries1[$i]->getDayOfMonth() == null ){
                                        if ($entries1[$i]->getDayOfWeek() == date('N') || $entries1[$i]->getDayOfWeek() == null){
                                            if ($entries1[$i]->getFrom() <= date("H:i:s") && $entries1[$i]->getUntil() >= date("H:i:s")){
                                                $status = $entries1[$i]->getIsActive();
                                                $publickey = $device->getPublicKey();
                                                $log->setEntry($entries1[$i]);
                                                break;
                                            }
                                        }
                                    }
                                }
                            }
                            $i ++;
                        }

                        if ($publickey == null){

                            $concreteProfile = $this->getDoctrine()->getRepository("CoreBundle:Profile")->findOneProfile($section->getId(), $user->getId());

                            if(!empty($concreteProfile)){

                                $entries2 = $concreteProfile[0]->getEntrys();

                                $i = 0;
                                while (!empty($entries2[$i])){
                                    if ($entries2[$i]->getYear() == date('Y') || $entries2[$i]->getYear() == null){
                                        if ($entries2[$i]->getMonth() == date('m') || $entries2[$i]->getDayOfMonth() == null ){
                                            if ($entries2[$i]->getDayOfMonth() == date('t') || $entries2[$i]->getDayOfMonth() == null ){
                                                if ($entries2[$i]->getDayOfWeek() == date('N') || $entries2[$i]->getDayOfWeek() == null){
                                                    $p1 = "ccc";
                                                    if ($entries2[$i]->getFrom2() <= date("H:i:s") && $entries2[$i]->getUntil2() >= date("H:i:s")){
                                                        $status = $entries2[$i]->getIsActive();
                                                        $publickey = $device->getPublicKey();
                                                        $log->setEntry($entries2[$i]);
                                                        break;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    $i ++;
                                }
                            }

                        }



                        $log->setSection($section);
                        $log->setDeviceReader($terminal);
                        $log->setUser($user);
                        $log->setDevice($device);
                        $log->fillCreatedAt();
                        $log->fillUpdatedAt();
                        $log->setStatus("True");
                        $log->setActivity("Prístup");

                        $em = $this->getDoctrine()->getManager();
                        $em->persist($log);
                        $em->flush();


                        $result = [
                            'uuid' => $data['uuid'],
                            'uuid_device' => $data['uuid_device'],
                            'status' => $status,
                            'public_key' => $publickey,

                        ];

                        return new JsonResponse($result, Response::HTTP_OK);

                    }else{
                        return new  JsonResponse('Wrong3333 json',Response::HTTP_BAD_REQUEST);
                    }
                }else{
                    return new  JsonResponse('Wrong222 json',Response::HTTP_BAD_REQUEST);
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