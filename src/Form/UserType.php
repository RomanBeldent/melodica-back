<?php

namespace App\Form;

use App\Entity\User;
use DateTimeImmutable;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Unique;

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
            ->add('birthday', DateType::class, [
                'label' => 'Date de naissance ',
                'widget' => 'single_text',
                'input' => 'datetime_immutable',
                'data_class' => Date::class,
                'required' => false,
                'mapped' => false, // ne pas enregistrer la valeur dans l'objet
                // 'empty_data' => "",

            ])
            ->add('email', EmailType::class, [
                'constraints'=> [
                    new Unique()
                ]
            ] )
            ->add('password', PasswordType::class)
            ->add('phone_number')
            ->add('picture')
            ->add('created_at')
            ->add('updated_at')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
