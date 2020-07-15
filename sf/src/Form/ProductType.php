<?php

namespace App\Form;

use App\Entity\CatProduct;
use App\Entity\GenderCat;
use App\Entity\Image;
use App\Entity\Product;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
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
            ->add('image', EntityType::class, array(
                'class' => Image::class,
                'choice_label' => 'name',
                'multiple' => false,
                'required' => true,
            ))
            ->add('price')
            ->add('description', CKEditorType::class)
            ->add('stock')
            ->add('gender', EntityType::class, array(
                'class' => GenderCat::class,
                'choice_label' => 'nom',
                'multiple' => false,
                'required' => true
            ))
            ->add('cat', EntityType::class, array(
                'class' => CatProduct::class,
                'choice_label' => 'name',
                'multiple' => false,
                'required' => true
            ))
            ->add('isSponso')
            ->add('isActive');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
