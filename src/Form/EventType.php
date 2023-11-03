<?php

namespace App\Form;

use App\Entity\Tag;
use App\Entity\Band;
use App\Entity\Event;
use App\Entity\Organizer;
use App\Form\AddressType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class,[
                'label'=>'Titre de l\'évènement',
                'constraints' =>[
                new Length([
                    'min'=> 5,
                    'max' => 50,
                    'minMessage' => 'Veuillez rentrer un titre entre 5 et 50 caractères',
                    'maxMessage'=> 'Veuillez rentrer un titre entre 5 et 50 caractères'
                ])
                ]
            ])
            ->add('description', TextType::class,[
                'label' => 'Description'
            ])
            ->add('date_start', DateType::class,[
                'label'=>'Date de début'
            ])
            ->add('date_end', DateType::class,[
                'label' => 'Date de fin'
            ])
            ->add('hour_start', TimeType::class,[
                'label'=>'Heure de début'
            ])
            ->add('hour_end',TimeType::class,[
                'label'=>'Heure de fin'
            ])
            ->add('picture', TextType::class,[
                'label'=>'Photo de profil de l\'évènement',
                'required'=>false
            ])
            ->add('created_at', DateTimeType::class, [
                'input' => 'datetime_immutable',
                'disabled' => true,
                ])
            ->add('updated_at', DateTimeType::class, [
                'input' => 'datetime_immutable',
                'disabled' => true,
            ])
            ->add('tags', EntityType::class,[
                'label'=>'Tag',
                'class' => Tag::class,
                'multiple'=> true,
            ])
            ->add('bands', EntityType::class,[
                'label'=>'Artiste',
                'class' => Band::class,
                'multiple' => true,
                'required' => false
            ])
            ->add('address', AddressType::class,[
                'label' => 'Adresse'
            ])
            ->add('organizer', EntityType::class,[
                'label' => 'Organisateur',
                'class' => Organizer::class,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
