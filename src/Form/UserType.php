<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'required' => true
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
                'required' => true
            ])
            ->add('birthday', BirthdayType::class, [
                'label' => 'Date de naissance',
                'widget' => 'single_text',
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'placeholder' => 'user@gmail.com',
            ]])
            ->add('password', PasswordType::class)
            ->add('phone_number', TextType::class, [
                'label' => 'Numéro de téléphone',
                'constraints' => [
            new Length([
                'min' => 10,
                'minMessage' => 'Veuillez rentrer un téléphone valide'
            ])
            ]])
            ->add('roles', ChoiceType::class, [
                    'choices' => [
                        'Admin' => "ROLE_ADMIN",
                        'Moderator' => "ROLE_MANAGER",
                        'User' => "ROLE_USER",
                    ],
                    'multiple' => true,
                    'expanded' => true,
            ])
             ->add('pictureFilename', FileType::class, [
                'label' => 'Photo de profil (jpeg,jpg,png)',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                     new File([
                        'maxSize' => '2m',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                            'image/webp'
                        ],
                        'mimeTypesMessage' => 'Veuillez rentrer une image au format JPEG/JPG/PNG',
                ])
            ],
        ])
    ;
}

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,

        ]);
    }
}
