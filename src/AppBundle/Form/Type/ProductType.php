<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\ProductCategory;
use AppBundle\Form\Type\ProductCategoryType;

class ProductType extends AbstractType
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
            ->add('finishedGoodsFlg', CheckboxType::class, array(
                'required' => false,
                'attr' => array('checked' => 'checked')
            ))
            ->add('number', TextType::class, array(
                'required' => false
            ))
            ->add('barCode', TextType::class, array(
                'required' => false
            ))
            ->add('status', ChoiceType::class, array(
                'required' => false,
                'placeholder' => ' ',
                'empty_data'  => null,
                'choices'  => array(
                    'En développement' => '1',
                    'Normal' => '2',
                    'Fin de cycle de vie' => '3',
                    'Obsolète'  => '4'
                )
            ))
            ->add('sellingPrice', TextType::class, array(
                'required' => false,
                'attr' => array(
                    'data-validation' => 'number'
                )
            ))
            ->add('quantity', IntegerType::class, array(
                'required' => false
            ))
            ->add('description', TextareaType::class, array(
                'required' => false
            ))
            ->add('photo', FileType::class, array(
                'required' => false,
                'data_class' => null
            ))
            ->add('tva', EntityType::class, array(
                'choice_label' => 'code',
                'class' => 'AppBundle:Tva',
                'placeholder' => 'Taux tva',
                'attr' => array(
                    'data-validation' => 'required'
                )
            ))
            ->add('category', EntityType::class, array(
                'required' => false,
                'attr' => array(
                    'data-live-search' => 'true',
                    'data-validation' => 'required'
                ),
                'choice_label' => 'name',
                'class' => 'AppBundle:ProductCategory',
                'placeholder' => 'Tous les catégories'
            ));

    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Product::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'product';
    }


}
