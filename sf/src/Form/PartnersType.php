<?php

namespace App\Form;

use App\Entity\Image;
use App\Entity\Partners;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PartnersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('logo', EntityType::class, array(
                'class' => Image::class,
                'choice_label' => 'name',
                'multiple' => false,
                'required' => true,
                'attr' => ['class' => "img-picker"]
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Partners::class,
        ]);
    }
}
