<?php
/**
 * Created by PhpStorm.
 * User: Nikolas
 * Date: 02.03.2017
 * Time: 2:18
 */

namespace ApiBundle\Controller;

use ApiBundle\Helper\Guid;
use CoreBundle\Entity\ApiEntity;
use CoreBundle\Entity\User;
use Doctrine\ORM\Id\UuidGenerator;
use phpseclib\Crypt\Hash;
use phpseclib\Crypt\RSA;
use Sinner\Phpseclib\Crypt\Crypt_RSA;
use Sinner\Phpseclib\PhpseclibBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\CssSelector\Parser\Token;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class UserController extends Controller
{

   public function listAction(Request $request)
  {
      //  $users = $this->getDoctrine()->getRepository("CoreBundle:User")->findAll();
      $rsa = new RSA();
      $key = $rsa->createKey();

     // $hash = new Hash();
        $ggssgs = "hgiahsjks";
    //  $hashkey= $hash->_sha512("heslo");

      $result = [

          //       'items' => ApiEntity::prepare($users),
          'metadata' => "ochjojoj",
          'uuid' => Guid::uuid(),
          'key_public'=> $key['publickey'],
          'key_private'=> $key['privatekey'],
          'fdhdgh' => "asfhsdgh"
   //       'hash' => $hashkey
      ];

        return new JsonResponse($result, Response::HTTP_OK);
   }

}