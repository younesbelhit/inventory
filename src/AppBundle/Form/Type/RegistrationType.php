<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;


class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstName', TextType::class, array(
                    'required' => false,
                    'attr' => array(
                        'data-validation' => 'required'
                    )
                ))
                ->add('lastName', TextType::class, array(
                    'required' => false,
                    'attr' => array(
                        'data-validation' => 'required'
                    )
                ))
                ->add('cellPhone', TextType::class, array(
                    'required' => false
                ))
                ->add('website',  UrlType::class, array(
                    'required' => false
                ))
                ->add('description', TextareaType::class, array(
                    'required' => false
                ));

    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getName()
    {
        return 'app_user_registration';
    }
}