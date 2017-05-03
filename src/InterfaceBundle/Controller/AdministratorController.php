<?php
/**
 * Created by PhpStorm.
 * User: Nikolas
 * Date: 22.04.2017
 * Time: 20:48
 */

namespace InterfaceBundle\Controller;


use ApiBundle\Helper\Guid;
use CoreBundle\Entity\User;
use InterfaceBundle\Form\AdministratorType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdministratorController extends Controller
{
    public function registrationAdministratorAction($id, Request $request){

        $user = new User();
        $user->setRole($this->getDoctrine()->getRepository("CoreBundle:Role")->findOneBy([
            'code' => "ROLE_ADMIN"
        ]));

        $user->setUuid(Guid::uuid());
        $section = $this->getDoctrine()->getRepository("CoreBundle:Section")->find($id);
        $user->addSection($section);

        $user->fillUpdatedAt();
        $user->fillCreatedAt();

        $form = $this->createForm(AdministratorType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $administratorRole = $this->getDoctrine()->getRepository("CoreBundle:Role")->findOneBy([
                'code' => "ROLE_ADMIN"
            ]);
            $administratorRole = $administratorRole->getId();
            $data = $this->getDoctrine()->getRepository("CoreBundle:User")->findAllAdministratorsBySection($id, $administratorRole);

            return $this->render('@Interface/Sections/administratorsSection.html.twig', [
                'users' => $data,
                'id_section' => $id
            ]);
        }

        return $this->render('@Interface/Administrators/createAdministrator.html.twig', array(
            'form' => $form->createView(),
            'id_section' => $id
        ));

    }

}