<?php

namespace App\Form;

use App\Entity\Features;
use App\Entity\Image;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FeaturesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('slug')
            ->add('description', CKEditorType::class)
            ->add('img', EntityType::class, array(
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
            'data_class' => Features::class,
        ]);
    }
}
