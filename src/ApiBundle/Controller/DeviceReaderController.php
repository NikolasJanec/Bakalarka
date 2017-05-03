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
            $admin_pass = $data['password'];
            $sec_name = $data['section_name'];
            $section = $this->getDoctrine()->getRepository("CoreBundle:Section")->findOneBy([
                'name' => $sec_name
            ]);
            $terminal = new DeviceReader();
            $terminal->setSection($section);
            $terminal->setIpAddress($data['ip_address']);
            $terminal->setPortNumber($data['port']);
            $terminal->setName($data['name']);
            $terminal->setUuid(Guid::uuid());
            $password = $this->get('security.password_encoder')
                ->encodePassword($admin, $admin_pass);

            if($password == $admin->getPassword()){
                $terminal->setToken('aaaaa');
            }else{
                $terminal->setToken('bbbb');
            }

            $terminal->setTypeReader($this->getDoctrine()->getRepository("CoreBundle:TypeReader")->findOneBy([
                'id' => $data['mode']
            ]));
            $terminal->fillCreatedAt();
            $terminal->fillUpdatedAt();

            $em = $this->getDoctrine()->getManager();
            $em->persist($terminal);
            $em->flush();
            $result = [
                'token' => $terminal->getId(),
                'uuid' => $terminal->getUuid()
            ];
            return new JsonResponse($result, Response::HTTP_CREATED);
        }
        else{
            return new  JsonResponse('Bad request',Response::HTTP_BAD_REQUEST);
        }

    }

    public function listAction(Request $request)
    {
        //$users = $this->getDoctrine()->getRepository("CoreBundle:User")->findAll();

        $result = [

            'metadata' => "ochjojoj",
            'uuid' => Guid::uuid()
         ];

        return new JsonResponse($result, Response::HTTP_OK);
    }


}