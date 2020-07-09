<?php

namespace App\Form;

use App\Entity\SiteConfig;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SiteConfigType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('learnMore',CKEditorType::class)
            ->add('careAndTips',CKEditorType::class)
            ->add('howWorks',CKEditorType::class)
            ->add('howWorksBg')
            ->add('headerBg')
            ->add('headerTitle', CKEditorType::class)
            ->add('headerSubtile', CKEditorType::class)
            ->add('seeenOnPress', CKEditorType::class)
            ->add('mapsUrl')
            ->add('aboutUs', CKEditorType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SiteConfig::class,
        ]);
    }
}
