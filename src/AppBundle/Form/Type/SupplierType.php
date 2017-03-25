<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Supplier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SupplierType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'required' => false,
                'attr' => array(
                    'data-validation' => 'required'
                )
            ))
            ->add('address', TextType::class, array(
                'required' => false
            ))
            ->add('city', TextType::class, array(
                'required' => false
            ))
            ->add('postalCode', TextType::class, array(
                'required' => false
            ))
            ->add('country', TextType::class, array(
                'required' => false
            ))
            ->add('phone', TextType::class, array(
                'required' => false
            ))
            ->add('cellPhone', TextType::class, array(
                'required' => false
            ))
            ->add('fax', TextType::class, array(
                'required' => false
            ))
            ->add('email', EmailType::class, array(
                'required' => false
            ))
            ->add('photo', FileType::class, array(
                'required' => false,
                'data_class' => null
            ))
            ->add('website', UrlType::class, array(
                'required' => false
            ))
            ->add('description', TextareaType::class, array(
                'required' => false
            ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Supplier::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_vendor';
    }


}
