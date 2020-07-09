<?php

namespace App\Form;

use App\Entity\CatProduct;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('img')
            ->add('price')
            ->add('description')
            ->add('stock')
            ->add('isSponso')
            ->add('isActive')
            ->add('cat', EntityType::class, array(
                'class' => CatProduct::class,
                'choice_label' => 'name',
                'multiple' => false,
                'required' => true
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
