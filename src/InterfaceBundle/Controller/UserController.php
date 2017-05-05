<?php
/**
 * Created by PhpStorm.
 * User: Nikolas
 * Date: 23.04.2017
 * Time: 22:27
 */

namespace InterfaceBundle\Controller;


use ApiBundle\Helper\Guid;
use CoreBundle\Entity\Entry;
use CoreBundle\Entity\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use InterfaceBundle\Form\TimeTableConcreteDayType;
use InterfaceBundle\Form\TimeTableEveryDayType;
use InterfaceBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{

    public function registrationUserAction($id, Request $request)
    {

        $user = new User();
        $user->setRole($this->getDoctrine()->getRepository("CoreBundle:Role")->findOneBy([
            'code' => "ROLE_USER"
        ]));

        $user->setUuid(Guid::uuid());
        $section = $this->getDoctrine()->getRepository("CoreBundle:Section")->find($id);
        $user->addSection($section);

        $user->fillUpdatedAt();
        $user->fillCreatedAt();

        $me = $this->getUser()->getSections();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $userRole = $this->getDoctrine()->getRepository("CoreBundle:Role")->findOneBy([
                'code' => "ROLE_USER"
            ]);
            $userRole = $userRole->getId();

            $data = $this->getDoctrine()->getRepository("CoreBundle:User")->findAllAdministratorsBySection($id, $userRole);

            return $this->render('@Interface/Sections/usersSection.html.twig', [
                'users' => $data,
                'id_section' => $id
            ]);
        }

        return $this->render('InterfaceBundle:Users:createUser.html.twig', array(
            'form' => $form->createView(),
            'id_section' => $id
        ));
    }

    public function viewUserAction(Request $request, $id_user){

        $user = $this->getDoctrine()->getRepository("CoreBundle:User")->find($id_user);

        return $this->render('InterfaceBundle:Users:viewUser.html.twig', array(
            'user' => $user,
            'pom_section' => 0
        ));

    }

    public function viewUserEntriesAction(Request $request, $id_user){

        $user = $this->getDoctrine()->getRepository("CoreBundle:User")->find($id_user);

        return $this->render('@Interface/Users/viewUserEntries.html.twig', array(
            'user' => $user
        ));
    }

    public function viewUserSectionsAction(Request $request, $id_user){

        $user = $this->getDoctrine()->getRepository("CoreBundle:User")->find($id_user);

        $sections = $user->getSections();
        $profiles = $user->getProfiles();

        $i = 0;
        $result = [];

        while(!empty($sections[$i])){
            $pom = [];
            $userSectionName = $sections[$i]->getName();
            $userSectionId = $sections[$i]->getId();
            $userProfileName = null;
            $userProfileId = 0;
            $a = 0;
            while (!empty($profiles[$a])){
                if($profiles[$a]->getSectionId() == $sections[$i]->getId()){
                    $userProfileName = $profiles[$a]->getName();
                    $userProfileId = $profiles[$a]->getId();
                    break;
                }
                $a ++;
            }
            $pom = [
                "section_name" => $userSectionName,
                "section_id" => $userSectionId,
                "profile_name" => $userProfileName,
                "profile_id" => $userProfileId
            ];

            array_push($result, $pom);


            $i ++;
        }

        return $this->render('@Interface/Users/viewUserSections.html.twig', array(
            'user' => $user,
            'sections' => $result

        ));
    }

    public function addUserSectionAction($id_user, $id_section, $id_profile, $id_action){
        $me = $this->getUser();
        $sections = null;
        $profiles = null;
        $specific = 0;


        $result = [];

        $my_sections = $me->getSections();

        $section = $this->getDoctrine()->getRepository("CoreBundle:Section")->find($id_section);
        $profile = $this->getDoctrine()->getRepository("CoreBundle:Profile")->find($id_profile);
        $user = $this->getDoctrine()->getRepository("CoreBundle:User")->find($id_user);

        $user_sections = $user->getSections();

        if($id_section == 0){
//            $sections = $this->getDoctrine()->getRepository("CoreBundle:Section")->findAllSectionsForUser($id_user, $me->getId());
        }elseif ($id_section != 0 && $id_profile == 0 && $id_action == 0){
//            $sections = $this->getDoctrine()->getRepository("CoreBundle:Section")->findAllSectionsForUser($id_user, $me->getId());
            $profiles = $this->getDoctrine()->getRepository("CoreBundle:Profile")->findBy([
                'sectionId' => $id_section
            ]);
        }elseif ($id_section != 0 && $id_profile == 0 && $id_action == 1){

            $user->addSection($section);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $specific = 1;
//            $sections = $this->getDoctrine()->getRepository("CoreBundle:Section")->findAllSectionsForUser($id_user, $me->getId());


        }elseif ($id_section != 0 && $id_profile != 0 && $id_action == 1){
            $user->addSection($section);
            $user->addProfile($profile);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $specific = 1;
            shell_exec(sprintf("nohup php %s/../bin/console api:update_user %s %s &",$this->get('kernel')->getRootDir(), $id_user, $id_section));
        }

        $i = 0;
        while (!empty($my_sections[$i])){
            $a = 0;
            while(!empty($user_sections[$a])){
                if($user_sections[$a]->getId() == $my_sections[$i]->getId()){
                    break;
                }
                $a ++;
            }
            if (empty($user_sections[$a])){
                array_push($result, $my_sections[$i]);
            }
            $i ++;
        }


        return $this->render('@Interface/Users/addUserSection.html.twig', array(
            'user' => $user,
            'sections' => $result,
            'profiles' => $profiles,
            'specific_section' => $id_section,
            'specific_profile' => $specific
        ));

    }

    public function deleteSectionAndProfileFromUserAction($id_user, $id_section, $id_profile){

        $section = $this->getDoctrine()->getRepository("CoreBundle:Section")->find($id_section);
        $profile = $this->getDoctrine()->getRepository("CoreBundle:Profile")->find($id_profile);
        $user = $this->getDoctrine()->getRepository("CoreBundle:User")->find($id_user);
        $devices = $user->getDevices();
        if ($id_profile != 0){
            $user->removeProfile($profile);
        }




            $readers = $section->getDeviceReaders();
            $b = 0;
            while (!empty($readers[$b])) {

                $type = $readers[$b]->getTypeReader();

                if($type->getCode() == "HYBRID")
                {
                   $i = 0;
                   while (!empty($devices[$i])){
                       $data = [
                           "device_uuid" => $readers[$b]->getUuid(),
                           "uuid" => $devices[$i]->getUuid(),

                       ];

                       $client = new Client(['verify' => false]);
                       try {

                           $url= "http://".$readers[$b]->getIpAddress().":".$readers[$b]->getPortNumber()."/v1/delete";

                           $client->request('POST', $url,

                               ['json' => $data]
                           );
                       } catch (ConnectException $e) {

                       }

                   }

                }
                $b ++;

            }


        $user->removeSection($section);
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        $user = $this->getDoctrine()->getRepository("CoreBundle:User")->find($id_user);
        $sections = $user->getSections();
        $profiles = $user->getProfiles();

        $i = 0;
        $result = [];



        while(!empty($sections[$i])){
            $pom = [];
            $userSectionName = $sections[$i]->getName();
            $userSectionId = $sections[$i]->getId();
            $userProfileName = null;
            $userProfileId = 0;
            $a = 0;
            while (!empty($profiles[$a])){
                if($profiles[$a]->getSectionId() == $sections[$i]->getId()){
                    $userProfileName = $profiles[$a]->getName();
                    $userProfileId = $profiles[$a]->getId();
                    break;
                }
                $a ++;
            }
            $pom = [
                "section_name" => $userSectionName,
                "section_id" => $userSectionId,
                "profile_name" => $userProfileName,
                "profile_id" => $userProfileId
            ];

            array_push($result, $pom);


            $i ++;
        }

        return $this->render('@Interface/Users/viewUserSections.html.twig', array(
            'user' => $user,
            'sections' => $result

        ));
    }

    public function viewTimeEntriesForSectionAndUserAction($id_user, $id_section){

        $section = $this->getDoctrine()->getRepository("CoreBundle:Section")->find($id_section);
        $user = $this->getDoctrine()->getRepository("CoreBundle:User")->find($id_user);

        $user_sections = $user->getSections();
        $entries = [];
        $timeEntriesYear = [];
        $timeEntriesEvery = [];

        if($id_section != 0){

            $entries = $this->getDoctrine()->getRepository("CoreBundle:Entry")->findBy([
                'userId' => $id_user,
                'sectionId' => $id_section,
            ]);

            $i = 0;
            while (!empty($entries[$i])){
                if($entries[$i]->getYear() == null){
                    array_push($timeEntriesEvery, $entries[$i]);

                }else{
                    array_push($timeEntriesYear, $entries[$i]);
                }
                $i ++;
            }

        }



        return $this->render('@Interface/Users/viewUserTimeEntries.html.twig', array(
            'user' => $user,
            'sections' => $user_sections,
            'id_section' => $id_section,
            'spec_entries' => $timeEntriesYear,
            'eve_entries' => $timeEntriesEvery

        ));

    }

    public function addEveryTimeEntryToUserAction($id_user, $id_section, Request $request)
    {

        $entry = new Entry();
        $section = $this->getDoctrine()->getRepository("CoreBundle:Section")->find($id_section);
        $user = $this->getDoctrine()->getRepository("CoreBundle:User")->find($id_user);
        $entry->setUser($user);
        $entry->setSection($section);
        $entry->fillCreatedAt();
        $entry->fillUpdatedAt();

        $form = $this->createForm(TimeTableEveryDayType::class, $entry);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($entry);
            $em->flush();

        }

        return $this->render('InterfaceBundle:Users:addUserEveryTimeEntry.html.twig', array(
            'form' => $form->createView(),
            'id_section' => $id_section,
            'id_user' => $id_user
        ));
    }

    public function addConcreteTimeEntryToUserAction($id_user, $id_section, Request $request)
    {

        $entry = new Entry();
        $section = $this->getDoctrine()->getRepository("CoreBundle:Section")->find($id_section);
        $user = $this->getDoctrine()->getRepository("CoreBundle:User")->find($id_user);
        $entry->setUser($user);
        $entry->setSection($section);
        $entry->fillCreatedAt();
        $entry->fillUpdatedAt();

        $form = $this->createForm(TimeTableConcreteDayType::class, $entry);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $em = $this->getDoctrine()->getManager();
            $em->persist($entry);
            $em->flush();

        }

        return $this->render('InterfaceBundle:Users:addUserConcretTimeEntry.html.twig', array(
            'form' => $form->createView(),
            'id_section' => $id_section,
            'id_user' => $id_user
        ));
    }

    public function deleteTimeEntryAction($id_user, $id_section, $id_entry){

        $entry = $this->getDoctrine()->getRepository("CoreBundle:Entry")->find($id_entry);
        $em = $this->getDoctrine()->getManager();
        $em->remove($entry);
        $em->flush();

        $section = $this->getDoctrine()->getRepository("CoreBundle:Section")->find($id_section);
        $user = $this->getDoctrine()->getRepository("CoreBundle:User")->find($id_user);

        $user_sections = $user->getSections();
        $entries = [];
        $timeEntriesYear = [];
        $timeEntriesEvery = [];

        if($id_section != 0){

            $entries = $this->getDoctrine()->getRepository("CoreBundle:Entry")->findBy([
                'userId' => $id_user,
                'sectionId' => $id_section,
            ]);

            $i = 0;
            while (!empty($entries[$i])){
                if($entries[$i]->getYear() == null){
                    array_push($timeEntriesEvery, $entries[$i]);

                }else{
                    array_push($timeEntriesYear, $entries[$i]);
                }
                $i ++;
            }

        }

        return $this->render('@Interface/Users/viewUserTimeEntries.html.twig', array(
            'user' => $user,
            'sections' => $user_sections,
            'id_section' => $id_section,
            'spec_entries' => $timeEntriesYear,
            'eve_entries' => $timeEntriesEvery

        ));

    }

    public function deleteUserDeviceAction($id_device, $id_user)
    {
        $device= $this->getDoctrine()->getRepository("CoreBundle:Device")->find($id_device);

        $user = $device->getUser();
        $sections = $user->getSections();

        $i = 0;

        while (!empty($sections[$i])) {


            $readers = $sections[$i]->getDeviceReaders();
            $b = 0;
            while (!empty($readers[$b])) {

                $type = $readers[$b]->getTypeReader();

                if($type->getCode() == "HYBRID")
                {

                    $data = [
                        "device_uuid" => $readers[$b]->getUuid(),
                        "uuid" => $device->getUuid(),

                    ];

                    $client = new Client(['verify' => false]);
                    try {

                        $url= "http://".$readers[$b]->getIpAddress().":".$readers[$b]->getPortNumber()."/v1/delete";

                        $client->request('POST', $url,

                            ['json' => $data]
                        );
                    } catch (ConnectException $e) {

                    }


                }
                $b ++;

            }
            $i ++;

        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($device);
        $em->flush();

        $user = $this->getDoctrine()->getRepository("CoreBundle:User")->find($id_user);
        $devices = $user->getDevices();

        return $this->render('@Interface/Users/viewUserDevices.html.twig',array(
            'devices' => $devices,
            'user' => $user
        ));

    }

    public function viewSectionUserAction(Request $request, $id_user, $id_section){

        $user = $this->getDoctrine()->getRepository("CoreBundle:User")->find($id_user);

        return $this->render('InterfaceBundle:Users:viewUser.html.twig', array(
            'user' => $user,
            'pom_section' => $id_section
        ));
    }


    public function updateReadersUserAction($id_user, $id_section){

        shell_exec(sprintf("nohup php %s/../bin/console api:update_user %s %s &",$this->get('kernel')->getRootDir(), $id_user, $id_section));

        var_dump($id_section);

        $section = $this->getDoctrine()->getRepository("CoreBundle:Section")->find($id_section);
        $user = $this->getDoctrine()->getRepository("CoreBundle:User")->find($id_user);

        $user_sections = $user->getSections();
        $entries = [];
        $timeEntriesYear = [];
        $timeEntriesEvery = [];

        if($id_section != 0){

            $entries = $this->getDoctrine()->getRepository("CoreBundle:Entry")->findBy([
                'userId' => $id_user,
                'sectionId' => $id_section,
            ]);

            $i = 0;
            while (!empty($entries[$i])){
                if($entries[$i]->getYear() == null){
                    array_push($timeEntriesEvery, $entries[$i]);

                }else{
                    array_push($timeEntriesYear, $entries[$i]);
                }
                $i ++;
            }

        }



        return $this->render('@Interface/Users/viewUserTimeEntries.html.twig', array(
            'user' => $user,
            'sections' => $user_sections,
            'id_section' => $id_section,
            'spec_entries' => $timeEntriesYear,
            'eve_entries' => $timeEntriesEvery

        ));


    }

    public function viewUserDevicesAction($id_user){
        $user = $this->getDoctrine()->getRepository("CoreBundle:User")->find($id_user);
        $devices = $user->getDevices();

        return $this->render('@Interface/Users/viewUserDevices.html.twig',array(
           'devices' => $devices,
            'user' => $user
        ));

    }




}