<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

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
            ->add('email', EmailType::class)
            ->add('password', PasswordType::class)
            ->add('phone_number', TextType::class, [
                'label' => 'Numéro de téléphone',
                'constraints' => [
            new Length([
                'min' => 10,
                'minMessage' => 'Veuillez rentrer un téléphone valide'
            ])
            ]])
            ->add('role', ChoiceType::class, [
                'label' => 'Droits de l\'utilisateur',
                'choices' => [
                   'User' => 'ROLE_USER',
                   'Moderator' => 'ROLE_MODERATOR',
                   'Admin' => 'ROLE_ADMIN',
                ],
            ])
            ->add('picture', TextType::class, [
                'label' => 'Photo de profil'
            ])
            ->add('created_at', DateTimeType::class, [
                'input' => 'datetime_immutable',
                'disabled' => true,
                ])
            ->add('updated_at', DateTimeType::class, [
                'input' => 'datetime_immutable',
                'disabled' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,

        ]);
    }
}
