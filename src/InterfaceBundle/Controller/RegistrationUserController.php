<?php
/**
 * Created by PhpStorm.
 * User: Nikolas
 * Date: 05.04.2017
 * Time: 15:57
 */

namespace InterfaceBundle\Controller;


use ApiBundle\ApiBundle;
use ApiBundle\Controller\SenderController;
use ApiBundle\Helper\Guid;
use CoreBundle\Entity\Log;
use CoreBundle\Entity\Profile;
use CoreBundle\Entity\User;
use HttpException;
use HttpRequest;
use InterfaceBundle\Form\RegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RegistrationUserController extends Controller
{
    public function registerUserAction(Request $request)
    {
        if ($request->isXMLHttpRequest())
        {
            $em = $this->getDoctrine()->getManager();

            $object = json_decode($request->getContent(),true);

            $user = new User;
            $user->setFirstName($object['first_name']);
            $user->setLastName($object['last_name']);
            $user->setUserName($object['username']);
            $user->setEmail($object['email']);
            $user->setPassword($object['password']);
            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $user->setRole($this->getDoctrine()->getRepository("CoreBundle:Role")->findOneBy([
                'id' => 2
            ]));
            $user->setUuid(Guid::uuid());
            $user->fillUpdatedAt();
            $user->fillCreatedAt();

            $section = $this->getDoctrine()->getRepository("CoreBundle:Section")->findOneBy([
                'name' => $object['section']
            ]);

            $user->addSection($section);

            $profile = $this->getDoctrine()->getRepository("CoreBundle:Profile")->find($object['profile']);
            $user->addProfile($profile);

            $em->persist($user);
            $em->flush();

            $log = new Log();
            $log->setUser($user);
            $log->setSection($section);



            return new JsonResponse(array('data' => $object));
        }

        return new Response('OK', 100);
    }
    public function getProfilesUserAction(Request $request)
    {

        if ($request->isXMLHttpRequest()) {

            $object = json_decode($request->getContent(),true);
            $name = $object['name'];

            $em = $this->getDoctrine()->getRepository("CoreBundle:Section")->findOneBy([
                'name' => $name
            ]);

            $names = array();
            $profiles = $em->getProfiles();
            foreach($profiles as $key => $value)
            {
                $names[]= array("name" => $value->getName(), "id" => $value->getId());
            }

            //you can return result as JSON
            return new JsonResponse(array('data' => $names));
        }

        return new Response('This is not ajax!', 400);
    }

    public function registrationUserAction(Request $request){


        $user = new User();
        $user->setRole($this->getDoctrine()->getRepository("CoreBundle:Role")->findOneBy([
            'id' => 2
        ]));


//            $user->setFirstName($request->request->get('_firstname'));
//            $user->setLastName($request->request->get('_lastname'));
        $user->setUuid(Guid::uuid());
//            $user->setUserName($request->request->get('_username'));
        $user->fillUpdatedAt();
        $user->fillCreatedAt();

        $me = $this->getUser()->getSections();


        $form = $this->createForm(RegistrationType::class, $user, array(
            'current_sections' => $me
        ));


//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($user);
//            $em->flush();
//        }

        return $this->render('InterfaceBundle:Registration:registrationuser.html.twig', [
            'form' => $form->createView()
        ]);

    }


}

