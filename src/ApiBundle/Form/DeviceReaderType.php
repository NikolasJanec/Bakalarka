<?php
/**
 * Created by PhpStorm.
 * User: Nikolas
 * Date: 07.03.2017
 * Time: 23:28
 */

namespace ApiBundle\Form;

use CoreBundle\Entity\DeviceReader;
use CoreBundle\Entity\TypeReader;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class DeviceReaderType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ipAddress', TextType::class, [
                'property_path' => 'ip_address',
                'required' => true,
                'label' => "Device-Reader ip address"
            ])
            ->add('portNumber', TextType::class, [
                'property_path' => 'port',
                'required' => true,
                'label' => "Device-Reader port"
            ])
            ->add('name', TextType::class, [
                'property_path' => 'name',
                'required' => true,
                'label' => "Device-Reader name"
            ])
            ->add('', TextType::class, [
                'property_path' => 'port',
                'required' => true,
                'label' => "Device-Reader port"
            ])
            ->add('typeReader', Entity::class, [
                'property_path' => 'mode',
                'required' => true,
                'label' => "Device-Reader mode",
                'class' => TypeReader::class
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
            'data_class' => DeviceReader::class,
            'allow_extra_fields' => true
        ]);
    }
}