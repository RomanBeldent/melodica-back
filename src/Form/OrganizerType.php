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
use Symfony\Component\Form\Extension\Core\Type\FileType;
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
                'label' => 'Photo du groupe (png, jpeg..)',
                // unmapped means that this field is not associated to any entity property
                'mapped' => false,
                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false])
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
