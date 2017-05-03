<?php
/**
 * Created by PhpStorm.
 * User: Nikolas
 * Date: 27.04.2017
 * Time: 4:17
 */

namespace InterfaceBundle\Form;


use CoreBundle\Entity\Entry;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TimeTableEveryDayType extends AbstractType
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
            ])
            ->add('isActive', ChoiceType::class,[
                'required' => true,
                'label' => "Status",
                'choices' => array(
                    'Zakázanie' => 0,
                    'Povolenie' => 1,
                )
            ])
            ->add('save', SubmitType::class, array(
                'attr' => array('class' => 'save'),
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Entry::class,
        ]);
    }
}