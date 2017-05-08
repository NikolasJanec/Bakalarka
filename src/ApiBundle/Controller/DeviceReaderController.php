<?php
/**
 * Created by PhpStorm.
 * User: Nikolas
 * Date: 07.03.2017
 * Time: 23:42
 */

namespace ApiBundle\Controller;

use ApiBundle\Helper\Guid;
use CoreBundle\Entity\DeviceReader;
use CoreBundle\Entity\Log;
use CoreBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\DateTime;

class DeviceReaderController extends Controller
{

    public function createAction(Request $request)
    {

        $data = json_decode($request->getContent(),true);
        if(!(empty($data))) {
            $admin_name = $data['administrator_name'];
            $admin = $this->getDoctrine()->getRepository("CoreBundle:User")->findOneBy([
                'userName' => $admin_name
            ]);
            if(!empty($admin)){
                $admin_pass = $data['password'];

                if(password_verify($admin_pass,$admin->getPassword())){
                    $sec_name = $data['section_name'];
                    $section = $this->getDoctrine()->getRepository("CoreBundle:Section")->findOneBy([
                        'name' => $sec_name
                    ]);

                    if(!empty($section)){
                        $mySections = $admin->getSections();
                        $i = 0;
                        $a = 0;
                        while (!empty($mySections[$i])){
                            if($mySections[$i]->getName() == $section->getName()){
                            $a = 1;
                            break;
                            }
                            $i ++;
                        }
                        if($a == 1){
                            $terminal = new DeviceReader();
                            $terminal->setSection($section);
                            $terminal->setIpAddress($data['ip_address']);
                            $terminal->setPortNumber($data['port']);
                            $terminal->setName($data['name']);
                            $terminal->setUuid(Guid::uuid());

                            $terminal->setTypeReader($this->getDoctrine()->getRepository("CoreBundle:TypeReader")->findOneBy([
                                'id' => $data['mode']
                            ]));
                            $terminal->fillCreatedAt();
                            $terminal->fillUpdatedAt();

                            $em = $this->getDoctrine()->getManager();
                            $em->persist($terminal);
                            $em->flush();

                            $log = new Log();
                            $log->setSection($section);
                            $log->setDeviceReader($terminal);
                            $log->setAdministrator($admin);
                            $log->fillCreatedAt();
                            $log->fillUpdatedAt();
                            $log->setStatus("True");
                            $log->setActivity("Vytvoril");

                            $em = $this->getDoctrine()->getManager();
                            $em->persist($log);
                            $em->flush();

                            $terminal->setToken($terminal->getId());
                            $em->persist($terminal);
                            $em->flush();
                            $result = [
                                'token' => $terminal->getToken(),
                                'uuid' => $terminal->getUuid()
                            ];
                            return new JsonResponse($result, Response::HTTP_CREATED);
                        }else{
                            return new  JsonResponse('You do not have this section in mind',Response::HTTP_BAD_REQUEST);
                        }

                    }else{
                        return new  JsonResponse('Wrong section name',Response::HTTP_BAD_REQUEST);
                    }

                }else{
                    return new  JsonResponse('Wrong password',Response::HTTP_BAD_REQUEST);
                }

            }else{
                return new  JsonResponse('Wrong Administrator name',Response::HTTP_BAD_REQUEST);
            }

        }else{
            return new  JsonResponse('Bad request',Response::HTTP_BAD_REQUEST);
        }
    }


}