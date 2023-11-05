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
use App\Entity\Band;
use App\Entity\Event;
use App\Entity\Organizer;
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
        mt_srand(1);
        // faker avec des datas française
        $faker = Factory::create('fr_FR');
        $faker->addProvider(new \Faker\Provider\fr_FR\Address($faker));
        
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
        for ($nbUserToAdd = 1; $nbUserToAdd < 50; $nbUserToAdd++) {
            $user = new User();
            $user->setFirstname($faker->firstName());
            $user->setLastname($faker->lastName());
            $user->setBirthday($faker->dateTimeThisCentury());
            $user->setEmail($faker->email());
            $hashedPassword = $this->passwordHasher->hashPassword($user, 'user');
            $user->setPassword($hashedPassword);
            $posterUrl = "https://picsum.photos/id/" . mt_rand(0, 1084) . "/200";
            $user->setPicture($posterUrl);
            $user->setPhoneNumber('06' . $faker->numberBetween(10000000, 99999999));
            $user->setCreatedAt(new DateTimeImmutable());
            $user->setRoles(['ROLE_USER']);

            $manager->persist($user);
            $userObjectList[] = $user;
        }

        // Fixture Address
        $addressObjectList = [];
        for ($nbAddressToAdd = 1; $nbAddressToAdd < 200; $nbAddressToAdd++) {

            $address = new Address();
            $address->setStreet($faker->streetAddress());
            $address->setCity($faker->city());
            $address->setZipcode($faker->departmentNumber());
            // on récupère les 2 premiers chiffres du zipcode pour l'ajouter dans department
            $addressFrstNbrs = $address->getZipcode();
            $address->setDepartment(substr($addressFrstNbrs, 0, 2));

            $manager->persist($address);
            $addressObjectList[] = $address;
        }

        // Fixture Organizer
        $organizerObjectList = [];
        for ($nbOrganizerToAdd = 1; $nbOrganizerToAdd < 50; $nbOrganizerToAdd++) {

            $organizer = new Organizer();
            $organizer->addUser($faker->randomElement($userObjectList));
            $organizer->setName($faker->unique()->company());
            $organizer->setWebsite('https://theuselessweb.com/');
            $organizer->setDescription($faker->text(30));
            $posterUrl = "https://picsum.photos/id/" . mt_rand(0, 1084) . "/1920/1080";
            $organizer->setPicture($posterUrl);
            $organizer->setCreatedAt(new DateTimeImmutable());

            $randomType = $faker->randomElement($typeObjectList);
            $organizer->setType($randomType);

            // ici il faut rendre l'adresse unique sinon on a un "duplicate key", en effet cette dernière doit être unique
            $randomAddress = $faker->unique()->randomElement($addressObjectList);
            $organizer->setAddress($randomAddress);

            $organizerObjectList[] = $organizer;
            $manager->persist($organizer);
        }

        // Fixture Band
        $bandObjectList = [];
        for ($nbBandToAdd = 1; $nbBandToAdd < 50; $nbBandToAdd++) {

            $band = new Band();
            $band->addUser($faker->randomElement($userObjectList));
            $band->setName($faker->unique()->words(2, true));
            $band->setDescription($faker->text(30));
            $band->setArea($faker->numberBetween(25, 1000));
            $posterUrl = "https://picsum.photos/id/" . mt_rand(0, 1084) . "/1920/1080";
            $band->setPicture($posterUrl);
            $band->setSample('https://www.youtube.com/watch?v=Lgs9QUtWc3M');
            $band->setCreatedAt(new DateTimeImmutable());

            $randomGenre = $faker->randomElement($genreObjectList);
            $band->addGenre($randomGenre);

            // ici il faut rendre l'adresse unique sinon on a un "duplicate key", en effet cette dernière doit être unique
            $randomAddress = $faker->unique()->randomElement($addressObjectList);
            $band->setAddress($randomAddress);

            $bandObjectList[] = $band;
            $manager->persist($band);
        }

        // Fixture Event
        $eventObjectList = [];
        for ($nbEventToAdd = 1; $nbEventToAdd < 50; $nbEventToAdd++) {

            $event = new Event();
            $event->setTitle($faker->unique()->words(3, true));
            $event->setDescription($faker->text(30));
            $event->setDateStart(new DateTimeImmutable());
            $event->setHourStart($faker->dateTime());
            $posterUrl = "https://picsum.photos/id/" . mt_rand(0, 1084) . "/1920/1080";
            $event->setPicture($posterUrl);
            $event->setCreatedAt(new DateTimeImmutable());
            $event->addTag($faker->randomElement($tagObjectList));
            $event->addBand($faker->randomElement($bandObjectList));
            $event->setOrganizer($faker->randomElement($organizerObjectList));

            $randomAddress = $faker->unique()->randomElement($addressObjectList);
            $event->setAddress($randomAddress);

            $manager->persist($event);
            $eventObjectList[] = $event;
        }

        $manager->flush();
    }
}
