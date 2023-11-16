<?php

namespace App\EventListener;

// src/App/EventListener/JWTCreatedListener.php

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

class JWTCreatedListener
{
// ici on gère l'envoie de donnée via le token JWT qui contiendra notamment ici
// l'id de l'utilisateur, le prénom , le nom , l'email et sa photo de profil
    public function onJWTCreated(JWTCreatedEvent $event)
    {

        $data = $event->getData();
        $user = $event->getUser();

        $data['id'] = $user->getId();
        $data['firstname'] = $user->getFirstname();
        $data['lastname'] = $user->getLastname();
        $data['email'] = $user->getEmail();
        $data['picture'] = $user->getPicture();

        $event->setData($data);
    }
}