<?php

namespace App\Form;

use App\Entity\Band;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BandType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('area')
            ->add('sample')
            ->add('picture')
            ->add('created_at')
            ->add('updated_at')
            ->add('users', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'firstname',
                'multiple' => true])
            ->add('events')
            ->add('tags')
            ->add('genre')
            ->add('address')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Band::class,
        ]);
    }
}
