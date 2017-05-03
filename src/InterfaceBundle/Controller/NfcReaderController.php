<?php
/**
 * Created by PhpStorm.
 * User: Nikolas
 * Date: 23.04.2017
 * Time: 16:01
 */

namespace InterfaceBundle\Controller;


use ApiBundle\Helper\Guid;
use CoreBundle\Entity\DeviceReader;
use InterfaceBundle\Form\NfcReaderType;
use InterfaceBundle\InterfaceBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class NfcReaderController extends Controller
{
    public function createOfflineReaderInSectionAction($id, Request $request)
    {
        $section = $this->getDoctrine()->getRepository("CoreBundle:Section")->find($id);

        $type = $this->getDoctrine()->getRepository("CoreBundle:TypeReader")->findOneBy([
            'code' => "OFFLINE"
        ]);

        $reader = new DeviceReader();

        $reader->setUuid(Guid::uuid());

        $reader->setSection($section);
        $reader->setTypeReader($type);

        $reader->fillUpdatedAt();
        $reader->fillCreatedAt();

        $form = $this->createForm(NfcReaderType::class, $reader);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $em = $this->getDoctrine()->getManager();
            $em->persist($reader);
            $em->flush();

            $filter = null;
            $data = $this->getDoctrine()->getRepository("CoreBundle:DeviceReader")->findAllReadersBySection($id, $filter);


            return $this->render('@Interface/Sections/nfcReadersSection.html.twig', [
                'readers' => $data,
                'id_section' => $id
            ]);
        }

        return $this->render('@Interface/ReaderDevice/createOfflineReaderFromSection.html.twig', array(
            'form' => $form->createView(),
            'id_section' => $id
        ));
    }

}