<?php
/**
 * Created by PhpStorm.
 * User: Nikolas
 * Date: 23.04.2017
 * Time: 18:09
 */

namespace InterfaceBundle\Controller;


use CoreBundle\Entity\Entry;
use CoreBundle\Entity\Profile;
use InterfaceBundle\Form\ProfileType;
use InterfaceBundle\Form\TimeTableConcreteDayType;
use InterfaceBundle\Form\TimeTableEveryDayType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProfileController extends Controller
{
    public function createProfileInSectionAction($id, Request $request)
    {
        $section = $this->getDoctrine()->getRepository("CoreBundle:Section")->find($id);


        $profile = new Profile();

        $profile->setSection($section);

        $profile->fillUpdatedAt();
        $profile->fillCreatedAt();

        $form = $this->createForm(ProfileType::class, $profile);

        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid()) {

            $entrys = $profile->getEntrys();

            foreach ($entrys as $entry ){
                $entry->setSection($section);
                $entry->setProfile($profile);
                $entry->fillCreatedAt();
                $entry->fillUpdatedAt();
                $entry->setIsActive(true);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($profile);
            $em->flush();

            $filter = null;
            $data = $this->getDoctrine()->getRepository("CoreBundle:Profile")->findAllProfilesBySection($id, $filter);

            return $this->render('@Interface/Sections/timeProfilesSection.html.twig', [
                'profiles' => $data,
                'id_section' => $id
            ]);
        }

        return $this->render('InterfaceBundle:Profile:createProfileInSection.html.twig', array(
            'form' => $form->createView(),
            'id_section' => $id
        ));
    }

    public function viewTimeProfileAction($id_profile, $id_section){
        $profile = $this->getDoctrine()->getRepository("CoreBundle:Profile")->find($id_profile);

        $entries = $profile->getEntrys();

        $entriesEveryDay = [];
        $entriesSpecificDay = [];

        $i = 0;
        while(!empty($entries[$i])){
            if($entries[$i]->getYear() != null){
                array_push($entriesSpecificDay,$entries[$i] );
            }else{
                array_push($entriesEveryDay,$entries[$i] );
            }
            $i ++;
        }

        return $this->render('@Interface/Profile/viewProfileInSection.html.twig', array(
            'id_section' => $id_section,
            'id_profile' => $id_profile,
            'spec_entries' => $entriesSpecificDay,
            'eve_entries' => $entriesEveryDay

        ));
    }


    public function addProfileTimeEveryEntryAction(Request $request, $id_section, $id_profile)
    {
        $entry = new Entry();
        $section = $this->getDoctrine()->getRepository("CoreBundle:Section")->find($id_section);
        $profile = $this->getDoctrine()->getRepository("CoreBundle:Profile")->find($id_profile);
        $entry->setProfile($profile);
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

        return $this->render('@Interface/Profile/addProfileConcretTimeEntry.html.twig', array(
            'form' => $form->createView(),
            'id_section' => $id_section,
            'id_profile' => $id_profile
        ));

    }

    public function addProfileTimeSpecEntryAction(Request $request, $id_section, $id_profile)
    {
        $entry = new Entry();
        $section = $this->getDoctrine()->getRepository("CoreBundle:Section")->find($id_section);
        $profile = $this->getDoctrine()->getRepository("CoreBundle:Profile")->find($id_profile);
        $entry->setProfile($profile);
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

        return $this->render('@Interface/Profile/addProfileConcretTimeEntry.html.twig', array(
            'form' => $form->createView(),
            'id_section' => $id_section,
            'id_profile' => $id_profile
        ));
    }

    public function deleteTimeEntryAction($id_profile, $id_section, $id_entry){

        $entry = $this->getDoctrine()->getRepository("CoreBundle:Entry")->find($id_entry);
        $em = $this->getDoctrine()->getManager();
        $em->remove($entry);
        $em->flush();

        $profile = $this->getDoctrine()->getRepository("CoreBundle:Profile")->find($id_profile);

        $entries = $profile->getEntrys();

        $entriesEveryDay = [];
        $entriesSpecificDay = [];

        $i = 0;
        while(!empty($entries[$i])){
            if($entries[$i]->getYear() != null){
                array_push($entriesSpecificDay,$entries[$i] );
            }else{
                array_push($entriesEveryDay,$entries[$i] );
            }
            $i ++;
        }

        return $this->render('@Interface/Profile/viewProfileInSection.html.twig', array(
            'id_section' => $id_section,
            'id_profile' => $id_profile,
            'spec_entries' => $entriesSpecificDay,
            'eve_entries' => $entriesEveryDay

       ));
    }
}