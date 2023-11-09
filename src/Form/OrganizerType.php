<?php

namespace App\Form;

use App\Entity\Type;
use App\Entity\User;
use App\Entity\Address;
use App\Entity\Organizer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class OrganizerType extends AbstractType
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
                'placeholder' => 'En 2018, j\'ai ouvert mon bar avec mon meilleur ami..',
            ]])
            ->add('website', TextType::class, [
                'label' => 'Site internet',
                'required' => false,
                'attr' => [
                'placeholder' => 'www.website.com',
            ]])
            ->add('picture', FileType::class, [
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
            ->add('type', EntityType::class, [
                'class' => Type::class,
                'choice_label' => 'name',
                'multiple' => false
            ])
            ->add('address', AddressType::class, [
                'label' => 'Adresse'
            ])
            ->add('users', EntityType::class, [
                'class' => User::class,
                'label' => 'Utilisateur(s)',
                'choice_label' => 'firstname',
                'multiple' => true]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Organizer::class,
        ]);
    }
}
