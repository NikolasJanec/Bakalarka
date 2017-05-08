<?php
/**
 * Created by PhpStorm.
 * User: Nikolas
 * Date: 23.04.2017
 * Time: 21:33
 */

namespace InterfaceBundle\Form;




use CoreBundle\Entity\Section;
use CoreBundle\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserSectionType extends AbstractType
{
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //este nie je implementovane problem convert object to string
        $user = $this->tokenStorage->getToken()->getUser()->getSections();

        if (!$user) {
            throw new \LogicException(
                'The FriendMessageFormType cannot be used without an authenticated user!'
            );
        }

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($user) {
                $form = $event->getForm();

                $section_names = array();
                foreach ($user as $key => $value)
                {
                    $section_names[] = $value->getName();
                }
                $section_names = array_combine($section_names, $section_names);
//                $formOptions = array(
//                    'class'         => Section::class,
//                    'choice_label'  => 'name',
//                    'query_builder' => function (EntityRepository $er) use ($user) {
//                        // build a custom query
//                        $er->createQueryBuilder('u')->addOrderBy('sec_name', 'DESC');
//
//                         return $er;
//
//                        // or call a method on your repository that returns the query builder
//                        // the $er is an instance of your UserRepository
//                        // return $er->createOrderByFullNameQueryBuilder();
//                    },
//                );

                // create the field, this is similar the $builder->add()
                // field name, field type, data, options
                $form->add('name', ChoiceType::class,[
                'required' => true,
                'label' => "Sekcia",
                'choices' => array(
                    $section_names


                )]);
            }
        );



    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Section::class,
        ]);
    }



}