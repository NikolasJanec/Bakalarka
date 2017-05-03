<?php
/**
 * Created by PhpStorm.
 * User: Nikolas
 * Date: 22.04.2017
 * Time: 19:35
 */

namespace InterfaceBundle\Form;


use CoreBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdministratorType extends AbstractType
{

     public function buildForm(FormBuilderInterface $builder, array $options)
    {
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
            ->add('email', TextType::class,[
                'required' => true,
                'label' => "Email"
            ])
            ->add('password', PasswordType::class,[
                'required' => true,
                'label' => "Password"
            ])
            ->add('save', SubmitType::class, array(
                'attr' => array('class' => 'save'),
            ));

    }

        public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

}