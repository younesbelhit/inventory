<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\SalesPayment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SalesPaymentType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('amount', TextType::class, array())
                ->add('paymentDate', TextType::class, array())
                ->add('paymentMethod', ChoiceType::class, array(
                    'placeholder' => ' ',
                    'choices'  => array(
                       'Espèce' => '1',
                       'Chèque' => '2',
                       'Virment' => '3'
                    )
                ))
                ->add('paymentReference', TextType::class, array())
                ->add('description', TextareaType::class, array());
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => SalesPayment::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_salespayment';
    }


}
