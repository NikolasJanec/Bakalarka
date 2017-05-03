<?php
/**
 * Created by PhpStorm.
 * User: Nikolas
 * Date: 19.04.2017
 * Time: 20:25
 */

namespace InterfaceBundle\Controller;


use CoreBundle\Entity\Log;
use CoreBundle\Entity\Section;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SectionController extends Controller
{

    public function indexAction(Request $request)
    {

        $me = $this->getUser();

        if ($request->getMethod() == Request::METHOD_POST && $request->request->get('sec_name') != null )
        {
            $filter = [
                'sec_name' => $request->request->get('sec_name'),
                'user_id' => $me->getId()
            ];

            $data = $this->getDoctrine()->getRepository("CoreBundle:Section")->findAllByFilteraa($filter);
        }
        else
        {
            $data = $me->getSections();
        }

        return $this->render('@Interface/Sections/main.html.twig', [
            'sections' => $data
        ]);
    }

    public function viewAction($id)
    {
        $user = $this->getDoctrine()->getRepository("CoreBundle:User")->find($id);

        return $this->render('InterfaceBundle:Default:user.html.twig', [
            'user' => $user
        ]);
    }

    public function viewAdministratorsSectionAction($id, Request $request)
    {
        $administratorRole = $this->getDoctrine()->getRepository("CoreBundle:Role")->findOneBy([
            'code' => "ROLE_ADMIN"
        ]);
        $administratorRole = $administratorRole->getId();

        $data = null;
        if ($request->getMethod() == Request::METHOD_POST && $request->request->get('query') != null )
        {
            $filter = [
                'query' => $request->request->get('query'),

            ];

            $data = $this->getDoctrine()->getRepository("CoreBundle:User")->findSpecificAdministratorsBySection($id, $administratorRole, $filter);
        }
        else
        {
            $data = $this->getDoctrine()->getRepository("CoreBundle:User")->findAllAdministratorsBySection($id, $administratorRole);
        }

        return $this->render('@Interface/Sections/administratorsSection.html.twig', [
            'users' => $data,
            'id_section' => $id
        ]);
    }

    public function addAdministratorToSectionAction($id, Request $request)
    {
        $administratorRole = $this->getDoctrine()->getRepository("CoreBundle:Role")->findOneBy([
            'code' => "ROLE_ADMIN"
        ]);
        $administratorRole = $administratorRole->getId();

        $filter = null;
        $data = null;


        if ($request->getMethod() == Request::METHOD_POST && $request->request->get('query') != null )
        {
            $filter = [
                'query' => $request->request->get('query'),

            ];

            $data = $this->getDoctrine()->getRepository("CoreBundle:User")->findSpecificAdministratorsNoInSection($id, $administratorRole, $filter);
        }
        else
        {
            $data = $this->getDoctrine()->getRepository("CoreBundle:User")->findSpecificAdministratorsNoInSection($id, $administratorRole, $filter);
        }

        return $this->render('@Interface/Sections/addAdministratorToSection.html.twig', [
            'users' => $data,
            'id_section' => $id
        ]);
    }

    public function addAdministratorAction($id, $id_user)
    {
        $user = $this->getDoctrine()->getRepository("CoreBundle:User")->find($id_user);
        $section = $this->getDoctrine()->getRepository("CoreBundle:Section")->find($id);
        $user->addSection($section);
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();


        $administratorRole = $this->getDoctrine()->getRepository("CoreBundle:Role")->findOneBy([
            'code' => "ROLE_ADMIN"
        ]);
        $administratorRole = $administratorRole->getId();

        $filter = null;


        $data = $this->getDoctrine()->getRepository("CoreBundle:User")->findSpecificAdministratorsNoInSection($id, $administratorRole, $filter);


        return $this->render('@Interface/Sections/addAdministratorToSection.html.twig', [
        'users' => $data,
        'id_section' => $id]);
    }

    public function deleteAdministratorfromSectionAction($id, $id_user)
    {
        $user = $this->getDoctrine()->getRepository("CoreBundle:User")->find($id_user);
        $section = $this->getDoctrine()->getRepository("CoreBundle:Section")->find($id);
        $user->removeSection($section);
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

    public function viewNfcReadersInSectionAction($id, Request $request)
    {

        $data = null;
        $filter = null;

        if ($request->getMethod() == Request::METHOD_POST && $request->request->get('query') != null )
        {
            $filter = [
                'query' => $request->request->get('query'),

            ];

            $data = $this->getDoctrine()->getRepository("CoreBundle:DeviceReader")->findAllReadersBySection($id, $filter);
        }
        else
        {
            $data = $this->getDoctrine()->getRepository("CoreBundle:DeviceReader")->findAllReadersBySection($id, $filter);
        }

        return $this->render('@Interface/Sections/nfcReadersSection.html.twig', [
            'readers' => $data,
            'id_section' => $id
        ]);
    }

    public function deleteReaderfromSectionAction($id, $id_reader)
    {
        $reader = $this->getDoctrine()->getRepository("CoreBundle:DeviceReader")->find($id_reader);
        $em = $this->getDoctrine()->getManager();
        $em->remove($reader);
        $em->flush();

        $filter = null;
        $data = $this->getDoctrine()->getRepository("CoreBundle:DeviceReader")->findAllReadersBySection($id, $filter);


        return $this->render('@Interface/Sections/nfcReadersSection.html.twig', [
            'readers' => $data,
            'id_section' => $id
        ]);
    }

    public function viewProfilesInSectionAction($id, Request $request)
    {

        $data = null;
        $filter = null;

        if ($request->getMethod() == Request::METHOD_POST && $request->request->get('query') != null )
        {
            $filter = [
                'query' => $request->request->get('query'),

            ];

            $data = $this->getDoctrine()->getRepository("CoreBundle:Profile")->findAllProfilesBySection($id, $filter);
        }
        else
        {
            $data = $this->getDoctrine()->getRepository("CoreBundle:Profile")->findAllProfilesBySection($id, $filter);
        }

        return $this->render('@Interface/Sections/timeProfilesSection.html.twig', [
            'profiles' => $data,
            'id_section' => $id
        ]);
    }

    public function deleteProfileFromSectionAction($id, $id_profile)
    {
        $reader = $this->getDoctrine()->getRepository("CoreBundle:Profile")->find($id_profile);
        $em = $this->getDoctrine()->getManager();
        $em->remove($reader);
        $em->flush();

        $filter = null;
        $data = $this->getDoctrine()->getRepository("CoreBundle:Profile")->findAllProfilesBySection($id, $filter);


        return $this->render('@Interface/Sections/timeProfilesSection.html.twig', [
        'profiles' => $data,
        'id_section' => $id
        ]);
    }

    public function viewUsersSectionAction($id, Request $request)
    {
        $userRole = $this->getDoctrine()->getRepository("CoreBundle:Role")->findOneBy([
            'code' => "ROLE_USER"
        ]);
        $userRole = $userRole->getId();

        $data = null;
        if ($request->getMethod() == Request::METHOD_POST && $request->request->get('query') != null )
        {
            $filter = [
                'query' => $request->request->get('query'),

            ];

            $data = $this->getDoctrine()->getRepository("CoreBundle:User")->findSpecificAdministratorsBySection($id, $userRole, $filter);
        }
        else
        {
            $data = $this->getDoctrine()->getRepository("CoreBundle:User")->findAllAdministratorsBySection($id, $userRole);
        }

        return $this->render('@Interface/Sections/usersSection.html.twig', [
            'users' => $data,
            'id_section' => $id
        ]);
    }

    public function createSectionAction( Request $request)
    {


        if ($request->getMethod() == Request::METHOD_POST && $request->request->get('name') != null ) {

            $me = $this->getUser();

            $section = new Section();

            $section->setName($request->request->get('name'));
            $section->fillUpdatedAt();
            $section->fillCreatedAt();

            $em = $this->getDoctrine()->getManager();
            $em->persist($section);
            $em->flush();

            $me->addSection($section);


            $em->persist($me);
            $em->flush();

            $log = new Log();

            $log->setAdministrator($me);
            $log->setSection($section);
            $log->setActivity("Vytvoril");
            $log->fillUpdatedAt();
            $log->fillCreatedAt();
            $em->persist($log);
            $em->flush();



        }

        return $this->render('@Interface/Sections/createSection.html.twig', []);
    }




}