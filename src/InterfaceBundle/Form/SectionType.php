<?php
/**
 * Created by PhpStorm.
 * User: Nikolas
 * Date: 12.04.2017
 * Time: 1:34
 */

namespace InterfaceBundle\Form;


use CoreBundle\Entity\Section;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SectionType extends  AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', ArrayCollection::class,[
                'required' => true,
                'label' => "Meno"
            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Section::class
        ]);
    }

}