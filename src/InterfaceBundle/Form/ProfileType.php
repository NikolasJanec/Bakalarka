<?php
/**
 * Created by PhpStorm.
 * User: Nikolas
 * Date: 23.04.2017
 * Time: 17:58
 */

namespace InterfaceBundle\Form;


use CoreBundle\Entity\Profile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class,[
                'required' => true,
                'label' => "Meno"
            ])
            ->add('entrys', CollectionType::class,array(
                'entry_type' => TimeTableType::class,
                'allow_add' => true,
                'label' => " "
            ))

            ->add('save', SubmitType::class, array(
                'attr' => array('class' => 'save'),
            ));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Profile::class,
        ]);
    }

}