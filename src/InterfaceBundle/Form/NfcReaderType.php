<?php
/**
 * Created by PhpStorm.
 * User: Nikolas
 * Date: 23.04.2017
 * Time: 16:04
 */

namespace InterfaceBundle\Form;


use CoreBundle\Entity\DeviceReader;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NfcReaderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class,[
                'required' => true,
                'label' => "Meno"
            ])
            ->add('note', TextType::class,[
                'required' => false,
                'label' => "Poznámka",
            ])

            ->add('save', SubmitType::class, array(
                'attr' => array('class' => 'save'),
            ));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DeviceReader::class,
        ]);
    }

}