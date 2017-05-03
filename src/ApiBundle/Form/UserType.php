<?php
/**
 * Created by PhpStorm.
 * User: Nikolas
 * Date: 03.03.2017
 * Time: 18:02
 */

namespace ApiBundle\Form;

use CoreBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class UserType extends AbstractType
{
//    public function buildForm(FormBuilderInterface $builder, array $options)
//    {
//        $builder
//            ->add('user_name', TextType::class, [
//                'property_path' => 'user_name',
//                'required' => true,
//                'label' => "User Username"
//            ])
//            ->add('owner', TextType::class, [
//                'property_path' => 'owner',
//                'required' => true,
//                'label' => "Device owner"
//            ])
//            ->add('description', TextType::class, [
//                'property_path' => 'description',
//                'required' => false,
//                'label' => "Device description"
//            ])
//            ->add('sensors', CollectionType::class, [
//                'entry_type' => SensorType::class,
//                'property_path' => 'sensors'
//            ])
//        ;
//    }
//
//    public function configureOptions(OptionsResolver $resolver)
//    {
//        $resolver->setDefaults([
//            'csrf_protection' => false,
//            'data_class' => User::class,
//            'allow_extra_fields' => true
//        ]);
//    }

}