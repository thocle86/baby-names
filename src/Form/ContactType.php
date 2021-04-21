<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints as Assert;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('transmitter', TextType::class, [
                'required' => false,
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Ce champ ne peut pas être vide',
                    ]),
                    new Assert\Length([
                        'min' => 2,
                        'minMessage' => 'Le nom de l\'émetteur doit faire au moins {{ limit }} caractères',
                        'max' => 255,
                        'maxMessage' => 'Le nom de l\'émetteur ne peut pas faire plus de {{ limit }} caractères',
                    ]),
                ]
            ])
            ->add('subject', TextType::class, [
                'required' => false,
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Ce champ ne peut pas être vide',
                    ]),
                    new Assert\Length([
                        'min' => 2,
                        'minMessage' => 'Le sujet doit faire au moins {{ limit }} caractères',
                        'max' => 255,
                        'maxMessage' => 'Le sujet ne peut pas faire plus de {{ limit }} caractères',
                    ]),
                ]
            ])
            ->add('email', EmailType::class, [
                'required' => false,
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Ce champ ne peut pas être vide',
                    ]),
                ]
            ])
            ->add('message', TextareaType::class, [
                'required' => false,
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Ce champ ne peut pas être vide',
                    ]),
                    new Assert\Length([
                        'min' => 2,
                        'minMessage' => 'Le message doit faire au moins {{ limit }} caractères',
                        'max' => 2000,
                        'maxMessage' => 'Le message ne peut pas faire plus de {{ limit }} caractères',
                    ]),
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
