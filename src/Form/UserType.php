<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Organizer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
            ->add('created_at', DateTimeType::class, [
                'input' => 'datetime_immutable',
                'disabled' => true,
                'label' => false,
                'attr' => [
                'style' => 'display:none',
            ]])
            ->add('updated_at', DateTimeType::class, [
                'input' => 'datetime_immutable',
                'disabled' => true,
                'label' => false,
                'attr' => [
                'style' => 'display:none',
            ]
        ])
        ->add('brochure', FileType::class, [
            'label' => 'Brochure (PDF file)',

            // unmapped means that this field is not associated to any entity property
            'mapped' => false,

            // make it optional so you don't have to re-upload the PDF file
            // every time you edit the Product details
            'required' => false,

            // unmapped fields can't define their validation using annotations
            // in the associated entity, so you can use the PHP constraint classes
            'constraints' => [
                new File([
                    'maxSize' => '1024k',
                    'mimeTypes' => [
                        'application/pdf',
                        'application/x-pdf',
                    ],
                    'mimeTypesMessage' => 'Please upload a valid PDF document',
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
