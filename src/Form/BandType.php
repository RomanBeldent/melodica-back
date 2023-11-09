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
use Symfony\Component\Validator\Constraints\File;
use Doctrine\DBAL\Types\TextType as TypesTextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class BandType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('description', TextType::class, [
                'label' => 'Description',
                'attr' => [
                'placeholder' => 'On est les Melodica Bangers, et on est pas là pour déconner !!',
            ]])
            ->add('area', IntegerType::class, [
                'label' => 'Zone de recherche autour de moi',
                'attr' => [
                'placeholder' => '50km',
            ]])
            ->add('sample', TextType::class, [
                'label' => 'Echantillon de musique',
                'required' => false,
                'attr' => [
                'placeholder' => 'https://www.youtube.com/watch?v=Xq7W5_QnkKo',
            ]])
            ->add('pictureFilename', FileType::class, [
                'label' => 'Photo de profil (jpeg,jpg,png)',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                     new File([
                        'maxSize' => '2m',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                            'image/webp'
                        ],
                        'mimeTypesMessage' => 'Veuillez rentrer une image au format JPEG/JPG/PNG',
                    ])
                ],
            ])
            ->add('address', AddressType::class, [
                'label' => 'Adresse'
            ])
            ->add('users', EntityType::class, [
                'class' => User::class,
                'label' => 'Utilisateur(s)',
                'choice_label' => 'firstname',
                'multiple' => true])
            ->add('tags', EntityType::class, [
                'label' => 'Vous êtes',
                'class' => Tag::class,
                'multiple' => true,
                'choice_label' => 'name'
            ])
            ->add('genres', EntityType::class, [
                'label' => 'Genre de musique',
                'choice_label' => 'name',
                'class' => Genre::class,
                'multiple' => true
            ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Band::class,
        ]);
    }
}
