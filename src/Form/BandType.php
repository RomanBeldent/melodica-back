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
use Symfony\Component\Form\Extension\Core\Type\FileType;

class BandType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,[
                'label'=>'Nom'
            ])
            ->add('description',TextType::class, [
                'label'=>'Description',
                'attr' => [
                'placeholder' => 'On est les Melodica Bangers, et on est pas là pour déconner !!',
            ]])
            ->add('area', IntegerType::class,[
                'label'=>'Zone de recherche autour de moi',
                'attr' => [
                'placeholder' => '50km',
            ]])
            ->add('sample',TextType::class,[
                'label' => 'Echantillon de musique',
                'required' => false,
                'attr' => [
                'placeholder' => 'https://www.youtube.com/watch?v=Xq7W5_QnkKo',
            ]])
            ->add('picture', FileType::class, [
                'label' => 'Photo du groupe (png, jpeg..)',
                // unmapped means that this field is not associated to any entity property
                'mapped' => false,
                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false])
            ->add('users', EntityType::class, [
                'class' => User::class,
                'label' => 'Utilisateur(s)',
                'choice_label' => 'firstname',
                'multiple' => true])
            ->add('tags', EntityType::class,[
                'label'=> 'Vous êtes',
                'class' => Tag::class,
                'multiple' => true,
                'choice_label' => 'name'
            ])
            ->add('genres', EntityType::class,[
                'label' => 'Genre de musique',
                'choice_label' => 'name',
                'class' => Genre::class,
                'multiple' => true
            ])
            ->add('address', AddressType::class,[
                'label'=>'Adresse'
            ]);       
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Band::class,
        ]);
    }
}
