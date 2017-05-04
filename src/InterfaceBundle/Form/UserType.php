<?php
/**
 * Created by PhpStorm.
 * User: Nikolas
 * Date: 23.04.2017
 * Time: 21:29
 */

namespace InterfaceBundle\Form;




use CoreBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
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
            ])
            ->add('userName', TextType::class,[
                'required' => true,
                'label' => "Používateľské meno"
            ])
            ->add('email', EmailType::class, [
                'required' => true,
                'label' => "Email"
            ])
            ->add('password', PasswordType::class,[
                'required' => true,
                'label' => "Heslo"
            ])

            ->add('sections', CollectionType::class,array(
                'entry_type' => UserSectionType::class,
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
            'data_class' => User::class
        ]);
    }


}