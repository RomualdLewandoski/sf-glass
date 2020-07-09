<?php

namespace App\Form;

use App\Entity\CatProduct;
use App\Entity\GenderCat;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CatProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('placement')
            ->add('gender', EntityType::class, array(
                'class' => GenderCat::class,
                'choice_label' => 'nom',
                'multiple' => false,
                'required' => true
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CatProduct::class,
        ]);
    }
}
