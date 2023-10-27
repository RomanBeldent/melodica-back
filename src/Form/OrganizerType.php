<?php

namespace App\Form;

use App\Entity\Organizer;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrganizerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('website')
            ->add('picture')
            ->add('created_at')
            ->add('updated_at')
            ->add('users', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'firstname',
                'multiple' => true])
            ->add('type')
            ->add('address')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Organizer::class,
        ]);
    }
}
