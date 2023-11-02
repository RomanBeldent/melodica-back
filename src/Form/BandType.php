<?php

namespace App\Form;

use App\Entity\Tag;
use App\Entity\Band;
use App\Entity\User;
use App\Entity\Genre;
use App\Entity\Address;
use App\Form\AddressType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\DBAL\Types\TextType as TypesTextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class BandType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,[
                'label'=>'Nom'
            ])
            ->add('description',TextType::class, [
                'label'=>'Description'
            ])
            ->add('area', IntegerType::class,[
                'label'=>'Zone de recherche autour de moi'
            ])
            ->add('sample',TextType::class,[
                'label' => 'Echantillon de musique',
                'required' => false
            ])
            ->add('picture',TextType::class,[
                'label'=>'Photo de profil',
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
            ->add('users', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'firstname',
                'multiple' => true])
            
            ->add('tags', EntityType::class,[
                'label'=> 'Qu\'êtes vous?',
                'class' => Tag::class,
                'multiple' => true,
                'choice_label' => 'name'
            ])
            ->add('genre', EntityType::class,[
                'label' => 'Votre genre de musique',
                'choice_label' => 'name',
                'class' => Genre::class,
                'multiple' => true
            ])
            ->add('address', AddressType::class,[
                'label'=>'Adresse',
            ]);
            
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Band::class,
        ]);
    }
}
