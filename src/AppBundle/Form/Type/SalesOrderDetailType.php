<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\SalesOrderDetail;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SalesOrderDetailType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('product', EntityType::class, array(
                'class' => 'AppBundle:Product',
                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                            ->where('p.quantity >= 5')
                            ->orderBy('p.id', 'DESC');
                },
                'placeholder' => 'Selectionnez un Produit',
                'required' => false,
                'label' => false,
                'attr' => array(
                    'class' => 'form-control',
                    'data-live-search' => 'true',
                    'data-validation' => 'required',
                    'data-id' => 'orderDetail_product'
                )
            ))
            ->add('orderQty', IntegerType::class, array(
                'label' => false,
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                    'data-validation' => 'number',
                    'data-id' => 'orderQty',
                    'min' => 0
                )
            ))
            ->add('unitPrice', TextType::class, array(
                'label' => false,
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                    'data-validation' => 'number',
                    'data-validation-allowing' => 'float',
                    'data-validation-decimal-separator' => ',',
                    'data-id' => 'unitPrice'
                )
            ))
            ->add('tva', TextType::class, array(
                'label' => false,
                'mapped' => false,
                'attr' => array(
                    'disabled' => true,
                    'class' => 'form-control',
                    'data-id' => 'tva'
                )
            ))
            ->add('lineTotal', TextType::class, array(
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                    'disabled' => true,
                    'data-id' => 'lineTotal'
                ),
                'label' => false
            ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => SalesOrderDetail::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'salesorderdetail';
    }


}
