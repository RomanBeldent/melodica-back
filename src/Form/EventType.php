<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class,[
                'label'=>'Titre de l\'évènement',
                new Length([
                    'min'=> 5,
                    'max' => 30,
                    'minMessage' => 'Veuillez rentrer un titre entre 5 et 30 caractères',
                    'maxMessage'=> 'Veuillez rentrer un titre entre 5 et 30 caractères'
                ])
            ])
            ->add('description')
            ->add('date_start')
            ->add('date_end')
            ->add('hour_start')
            ->add('hour_end')
            ->add('picture')
            ->add('created_at')
            ->add('updated_at')
            ->add('tag')
            ->add('band')
            ->add('address')
            ->add('organizer')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
