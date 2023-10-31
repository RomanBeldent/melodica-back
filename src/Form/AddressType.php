<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('street', TextType::class, [
            'label' => 'Rue',
            'required' => true
        ])
        ->add('zipcode', TextType::class, [
            'label' => 'Code postal',
            'required' => true
        ])
        ->add('city', TextType::class, [
            'label' => 'Ville',
            'required' => true
        ])
        ->add('department', ChoiceType::class, [
            'choices' => [
                '75' => "75",
                '33' => "33",
                '44' => "44",
                '78' => "78",
            ],
            'label' => 'Département',
            'required' => true
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
