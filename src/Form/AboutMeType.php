<?php

namespace App\Form;

use App\Entity\AboutMe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class AboutMeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('avatar', FileType::class, [
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '200k',
                        'maxSizeMessage' => 'La photo dépasse la limite de 200k !',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                        ],
                        'mimeTypesMessage' => 'Le format choisi est invalide ! => png ou jpeg uniquement',
                    ])
                ],
            ])
            ->add('myJobTitle', TextType::class)
            ->add('myJobText', TextType::class)
            ->add('myNewsTitle', TextType::class)
            ->add('myNewsText', TextType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AboutMe::class,
        ]);
    }
}
