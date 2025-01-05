<?php

declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Contracts\Translation\TranslatorInterface;

class ResetPasswordRequestFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => [
                    'autocomplete' => 'email',
                    'class' => 'border w-full',
                ],
                'label' => 'Email :',
//                'help' => 'Enter your email address and we\'ll send you a link to reset your password.',
                'help' => 'Entrée votre adresse email et nous vous enverrons un lien pour réinitialiser votre mot de passe.',
                'constraints' => [
                    new NotBlank([
//                        'message' => 'Please enter your email',
                        'message' => 'Veuillez entrer votre adresse email',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'attr' => [
                'class' => 'p-5 rounded-lg w-fit mx-auto mt-10 border'
            ],
        ]);
    }
}
