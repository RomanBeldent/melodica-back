<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\Organizer;
use App\Entity\Type;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrganizerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('description', TextType::class, [
                'label' => 'Description'
            ])
            ->add('website', TextType::class, [
                'label' => 'Site internet'
            ])
            ->add('picture')
            ->add('type', EntityType::class, [
                'class' => Type::class,
                'choice_label' => 'name',
                'multiple' => false
            ])
            // ->add('street', EntityType::class, [
            // 'class' => Address::class,
            // 'mapped'      => false,
            // 'required'    => false
            // ])
            ->add('street', CollectionType::class, [
                'entry_type' => AddressType::class,
                'entry_options' => ['label' => false],
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
            'data_class' => Organizer::class,
        ]);
    }
}
