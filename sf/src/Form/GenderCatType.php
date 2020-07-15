<?php

namespace App\Form;

use App\Entity\GenderCat;
use App\Entity\Image;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GenderCatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('headerBg', EntityType::class, array(
                'class' => Image::class,
                'choice_label' => 'name',
                'multiple' => false,
                'required' => true,
            ))
            ->add('slug')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => GenderCat::class,
        ]);
    }
}
