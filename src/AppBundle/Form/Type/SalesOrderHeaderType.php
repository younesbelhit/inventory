<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\SalesOrderHeader;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SalesOrderHeaderType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('customer', EntityType::class, array(
                'class' => 'AppBundle:Customer',
                'choice_label' => 'name',
                'required' => false,
                'attr' => array(
                    'data-validation' => 'required',
                    'data-live-search' => 'true'
                ),
                'placeholder' => 'Selectionnez un client'
            ))
            ->add('customerNumber', TextType::class, array(
                'required' => false
            ))
            ->add('orderDate', DateType::class, array(
                'widget' => 'single_text',
                'attr' => array(
                    'data-validation' => 'date'
                )
            ))
            ->add('shipDate', DateType::class, array(
                'required' => false,
                'widget' => 'single_text'
            ))
            ->add('salesOrderDetail', CollectionType::class, array(
                'entry_type' => SalesOrderDetailType::class,
                'allow_add'    => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => false
            ))
            ->add('totalHT', TextType::class, array(
                'attr' => array('disabled' => true)
            ))
            ->add('totalTTC', TextType::class, array(
                'attr' => array('disabled' => true)
            ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => SalesOrderHeader::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'salesorderheader';
    }


}
