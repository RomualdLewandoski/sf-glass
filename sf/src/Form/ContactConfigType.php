<?php

namespace App\Form;

use App\Entity\ContactConfig;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactConfigType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('infoMail')
            ->add('customerMail')
            ->add('salesMail')
            ->add('pressMail')
            ->add('instagramm')
            ->add('pinterest')
            ->add('twitter')
            ->add('facebook')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ContactConfig::class,
        ]);
    }
}
