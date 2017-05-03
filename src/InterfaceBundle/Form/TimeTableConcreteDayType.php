<?php
/**
 * Created by PhpStorm.
 * User: Nikolas
 * Date: 27.04.2017
 * Time: 4:21
 */

namespace InterfaceBundle\Form;


use CoreBundle\Entity\Entry;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TimeTableConcreteDayType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('year', IntegerType::class,[
                'required' => true,
                'label' => "Rok",
            ])
            ->add('month', IntegerType::class,[
                'required' => true,
                'label' => "Mesiac",
            ])
            ->add('dayOfMonth', IntegerType::class,[
                'required' => true,
                'label' => "Deň",
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