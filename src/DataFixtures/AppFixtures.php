<?php

// src/DataFixtures/AppFixtures.php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Tag;

use App\Entity\Type;
use App\Entity\User;
use App\Entity\Genre;
use DateTimeImmutable;
use App\Entity\Address;
use App\Entity\Organizer;
use Faker\Provider\fr_FR\PhoneNumber;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $passwordHasher;
    // injecter une dépendance
    public function __construct(UserPasswordHasherInterface $passwordHasherInterface)
    {
        $this->passwordHasher = $passwordHasherInterface;
    }

    public function load(ObjectManager $manager)
    {


        $faker = Factory::create('fr_FR');

        // AJOUT DE GENRE

        $genreNames = [];
        $genreNames[] = 'Electro';
        $genreNames[] = 'Metal';
        $genreNames[] = 'Reggae';
        $genreNames[] = 'Funk';
        $genreNames[] = 'Rock';
        $genreNames[] = 'Classique';
        $genreNames[] = 'RNB';
        $genreNames[] = 'Rap';


        $genreObjectList = [];
        foreach ($genreNames as $currentGenreName) {
            $genre = new Genre();
            $genre->setName($currentGenreName);
            $manager->persist($genre);
            $genreObjectList[] = $genre;
        }
        // Fixture Tag
        $tagNames = [];
        $tagNames[] = 'DJ';
        $tagNames[] = 'Chanteur';
        $tagNames[] = 'Groupe';
        $tagNames[] = 'Guitariste';
        $tagNames[] = 'Scratcher';

        $tagObjectList = [];
        foreach ($tagNames as $currentTagName) {
            $tag = new Tag();
            $tag->setName($currentTagName);
            $manager->persist($tag);
            $tagObjectList[] = $tag;
        }
        //Fixtures Type
        $typeNames = [];
        $typeNames[] = 'Bar';
        $typeNames[] = 'Particulier';
        $typeNames[] = 'Festival';
        $typeNames[] = 'Association';


        $typeObjectList = [];
        foreach ($typeNames as $currentTypeName) {
            $type = new Type();
            $type->setName($currentTypeName);
            $manager->persist($type);
            $typeObjectList[] = $type;
        }



        // AJOUT DE USER

        $userObjectList = [];
        for ($nbUserToAdd = 1; $nbUserToAdd < 20; $nbUserToAdd++) {
            $user = new User();
            $user->setFirstname($faker->firstName());
            $user->setLastname($faker->lastName());
            $user->setBirthday($faker->dateTimeThisCentury());
            $user->setEmail($faker->email());
            $hashedPassword = $this->passwordHasher->hashPassword($user, 'user');
            $user->setPassword($hashedPassword);
            $posterUrl = "https://picsum.photos/id/" . mt_rand(0, 1084) . "/200";
            $user->setPicture($posterUrl);
            $user->setPhoneNumber($faker->mobileNumber());
            $user->setCreatedAt(new DateTimeImmutable());
            $user->setRoles(['ROLE_USER']);


            $manager->persist($user);
            $userObjectList[] = $user;
        }
        // Fixture Address
        $addressObjectList = [];
        for ($nbAddressToAdd = 1; $nbAddressToAdd < 20; $nbAddressToAdd++) {

            $address = new Address();
            $address->setStreet($faker->streetAddress());
            $address->setZipcode($faker->numberBetween(10000, 99999));
            $address->setCity($faker->city());
            $address->setDepartment($faker->departmentName());

            $manager->persist($address);
            $addressObjectList[] = $address;
        }
        // Fixture Organizer
        $organizerObjectList = [];
        for ($nbOrganizerToAdd = 1; $nbOrganizerToAdd < 20; $nbOrganizerToAdd++) {

            $organizer = new Organizer();
            $organizer->addUser($faker->randomElement($userObjectList));
            $organizer->setName($faker->company());
            $organizer->setWebsite('https://theuselessweb.com/');
            $organizer->setDescription($faker->text(30));
            $posterUrl = "https://picsum.photos/id/" . mt_rand(0, 1084) . "/1920/1080";
            // $posterUrl = $faker->imageUrl(200, 300, 'animals', true);
            $organizer->setPicture($posterUrl);
            $organizer->setCreatedAt(new DateTimeImmutable());

            $randomType = $faker->randomElement($typeObjectList);
            $organizer->setType($randomType);

            $randomAddress = $faker->unique()->randomElement($addressObjectList);
            $organizer->setAddress($randomAddress);

            $organizerObjectList[] = $organizer;
            $manager->persist($organizer);

        }

        $manager->flush();
    }
}
