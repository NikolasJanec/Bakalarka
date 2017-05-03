<?php
/**
 * Created by PhpStorm.
 * User: Nikolas
 * Date: 05.04.2017
 * Time: 18:34
 */

namespace InterfaceBundle\Form;


use CoreBundle\Entity\Section;
use CoreBundle\Entity\User;
use InterfaceBundle\InterfaceBundle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $me = $options['current_sections'];
        $section_names = array();
        foreach ($me as $key => $value)
        {
            $section_names[] = $value->getName();
        }

        $section_names = array_combine($section_names, $section_names);

        $builder
            ->add('firstName', TextType::class,[
                'required' => true,
                'label' => "Meno"
            ])
            ->add('lastName', TextType::class,[
                'required' => true,
                'label' => "Priezvisko",
                'attr' => [
                    'style' => 'color: red;'
                ]
            ])
            ->add('userName', TextType::class,[
                'required' => true,
                'label' => "UserName"
            ])
//            ->add('sections', ChoiceType::class, [
//                'entry_type' => SectionType::class,
//            ])
            ->add('sections', ChoiceType::class,
                [
                    'choices' => $section_names
                ])
            ->add('save', SubmitType::class, array(
                'attr' => array('class' => 'save'),
            ));


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
           'data_class' => User::class,
            'current_sections' => null
        ]);
    }


}