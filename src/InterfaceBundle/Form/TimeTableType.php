<?php
/**
 * Created by PhpStorm.
 * User: Nikolas
 * Date: 05.04.2017
 * Time: 18:43
 */

namespace InterfaceBundle\Form;


use CoreBundle\Entity\Entry;
use CoreBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TimeTableType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('dayOfWeek', ChoiceType::class,[
                'required' => true,
                'label' => "Ďen",
                'choices' => array(
                    'Pondelok' => 1,
                    'Utorok' => 2,
                    'Streda' => 3,
                    'Stvrtok' => 4,
                    'Piatok' => 5,
                    'Sobota' => 6,
                    'Nedela' => 7
                )
            ])
            ->add('from', TimeType::class,[
                'required' => true,
                'label' => "Od",

            ])
            ->add('until', TimeType::class,[
                'required' => true,
                'label' => "Do"
            ]);


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Entry::class,
        ]);
    }



}