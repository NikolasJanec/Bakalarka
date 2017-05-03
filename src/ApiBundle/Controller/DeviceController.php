<?php
/**
 * Created by PhpStorm.
 * User: Nikolas
 * Date: 08.03.2017
 * Time: 16:05
 */

namespace ApiBundle\Controller;
use ApiBundle\Helper\Guid;
use CoreBundle\Entity\ApiEntity;
use CoreBundle\Entity\Device;
use CoreBundle\Entity\User;
use Doctrine\ORM\Id\UuidGenerator;
use phpseclib\Crypt\RSA;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Process\Process;

class DeviceController extends Controller
{

    public function createAction(Request $request, $id){
        $data = json_decode($request->getContent(),true);
        if(!(empty($data))) {
            $terminal = $this->getDoctrine()->getRepository("CoreBundle:DeviceReader")->find($id);
            if ($terminal->getUuid() != $data['uuid']){
                return new  JsonResponse('Bad device reader',Response::HTTP_BAD_REQUEST);
            }
            $user = $this->getDoctrine()->getRepository("CoreBundle:User")->findOneBy([
                'userName' => $data['username']
            ]);
                if (!$user){
                    return new  JsonResponse('User do not exist',Response::HTTP_BAD_REQUEST);
                }

                $device = new Device();
                $device->setUuid(Guid::uuid());
                $device->setName("mobilne zariadenie");
                $rsa = new RSA();
                $key = $rsa->createKey();
                $device->setPublicKey($key['publickey']);
                $device->setPrivateKey($key['privatekey']);
                $device->setUser($this->getDoctrine()->getRepository("CoreBundle:User")->findOneBy([
                    'userName' => $data['username']
                ]));
                $device->fillCreatedAt();
                $device->fillUpdatedAt();

                $em = $this->getDoctrine()->getManager();
                $em->persist($device);
                $em->flush();

                $result = [
                    'username' => $data['username'],
                    'device_uuid' => $device->getUuid(),
                    'device_private_key' => $device->getPrivateKey()
                ];

                $process = new Process(sprintf("php %s/../bin/console api:update_terminals %s",$this->get('kernel')->getRootDir(), $device->getUuid()));
                $process->start();

                while ($process->isRunning())
                {

                }

                var_dump($process->getOutput());
                var_dump($process->getErrorOutput());

                return new JsonResponse($result, Response::HTTP_CREATED);
        }
        else{
            return new  JsonResponse('Bad request',Response::HTTP_BAD_REQUEST);
        }
    }
}