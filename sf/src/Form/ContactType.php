<?php

namespace App\Form;

use App\Entity\Contact;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fullName')
            ->add('email')
            ->add('subject')
            ->add('comment', CKEditorType::class)
            ->add('agreeTerms', CheckboxType::class, [
                'label' => "By continuing you agree to our <a style=\"color: #767676; text-decoration: none;\" href=\"terms.html\">Terms of Service</a> and <a style=\"color: #767676; text-decoration: none;\" href=\"policy.html\">Privacy Policy</a>.",
                'label_html' => true,
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
