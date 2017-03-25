<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\PurchaseOrderHeader;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PurchaseOrderHeaderType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('supplier', EntityType::class, array(
                'class' => 'AppBundle:Supplier',
                'choice_label' => 'name',
                'required' => false,
                'attr' => array(
                    'data-live-search' => 'true',
                    'data-validation' => 'required'
                ),
                'placeholder' => 'Selectionnez un fournisseur'
            ))
            ->add('supplierNumber', TextType::class, array(
                'required' => false
            ))
            ->add('orderDate', DateType::class, array(
                'widget' => 'single_text',
                'attr' => array('data-validation' => 'date')
            ))
            ->add('shipDate', DateType::class, array(
                'required' => false,
                'widget' => 'single_text',
                'attr' => array('data-validation' => 'date')
            ))
            ->add('purchaseOrderDetail', CollectionType::class, array(
                'entry_type' => PurchaseOrderDetailType::class,
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
            'data_class' => PurchaseOrderHeader::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'purchaseorderheader';
    }


}
