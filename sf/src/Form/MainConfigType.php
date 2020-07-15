<?php

namespace App\Form;

use App\Entity\Image;
use App\Entity\MainConfig;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MainConfigType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('headerBg', EntityType::class, array(
                'class' => Image::class,
                'choice_label' => 'name',
                'multiple' => false,
                'required' => true,
                'attr' => ['class' =>"img-picker"]

            ))
            ->add('headerTitle')
            ->add('headerSub')
            ->add('gender1Bg', EntityType::class, array(
                'class' => Image::class,
                'choice_label' => 'name',
                'multiple' => false,
                'required' => true,
                'attr' => ['class' =>"img-picker"]

            ))
            ->add('gender1Title')
            ->add('gender1Slug')
            ->add('gender2Bg', EntityType::class, array(
                'class' => Image::class,
                'choice_label' => 'name',
                'multiple' => false,
                'required' => true,
                'attr' => ['class' =>"img-picker"]

            ))
            ->add('gender2Title')
            ->add('gender2Slug');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MainConfig::class,
        ]);
    }
}
