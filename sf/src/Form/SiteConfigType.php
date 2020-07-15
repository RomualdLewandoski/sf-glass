<?php

namespace App\Form;

use App\Entity\Image;
use App\Entity\SiteConfig;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SiteConfigType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('learnMore', CKEditorType::class)
            ->add('careAndTips', CKEditorType::class)
            ->add('howWorksBg', EntityType::class, array(
                'class' => Image::class,
                'choice_label' => 'name',
                'multiple' => false,
                'required' => true,
                'attr' => ['class' => "img-picker"]
            ))
            ->add('howWorks', CKEditorType::class)
            ->add('seenOnPress', CKEditorType::class)
            ->add('mapsUrl');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SiteConfig::class,
        ]);
    }
}
