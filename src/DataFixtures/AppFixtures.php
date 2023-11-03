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

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        
        
        $faker = Factory::create('fr_FR');
        // $faker->addProvider(new \Xylis\FakerCinema\Provider\Movie($faker));
        // $faker->addProvider(new \Xylis\FakerCinema\Provider\TvShow($faker));

        // AJOUT DE GENRE
        // pareil la création de genre à faire hors des movies sinon tu recréé la liste pour chaque movie

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
        // a faire hors de la boucle de création de movie
        // la tu crées à chaque fois 500 user à chaque création de Movie ( c'est excessif (un peu oui) )
        $userObjectList = [];
        for ($nbUserToAdd = 1; $nbUserToAdd < 20; $nbUserToAdd++) {
            $user = new User();
            $user->setFirstname($faker->firstName());
            $user->setLastname($faker->lastName());
            $user->setBirthday($faker->dateTimeThisCentury());
            $user->setEmail($faker->email());
            $user->setPassword($faker->password());
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
            $address->setZipcode($faker->numberBetween(10000,99999));
            $address->setCity($faker->city());
            $address->setDepartment($faker->departmentName());

            $manager->persist($address);
            $addressObjectList[] = $address;
        }
        // Fixture Organizer
        $organizerObjectList = [];
        for ($nbOrganizerToAdd = 1; $nbOrganizerToAdd < 20; $nbOrganizerToAdd++) {
            
            $organizer = new Organizer();
            $organizer->setName($faker->name());
            $organizer->setDescription($faker->text(30));
            $organizer->setCreatedAt(new DateTimeImmutable());
            $organizer->getType(0);
            
            $manager->persist($organizer);
            $organizerObjectList[] = $organizer;
        }
// $movie->setType($movieType[mt_rand(0, 1)]);

        $manager->flush();
    }
}
