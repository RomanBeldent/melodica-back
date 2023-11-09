<?php

namespace App\EventListener;

// src/App/EventListener/JWTCreatedListener.php

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

class JWTCreatedListener
{

    public function onJWTCreated(JWTCreatedEvent $event)
    {

        $data = $event->getData();
        $user = $event->getUser();

        $data['id'] = $user->getId();
        $data['firstname'] = $user->getFirstname();
        $data['lastname'] = $user->getLastname();
        $data['email'] = $user->getEmail();

        $event->setData($data);
    }
}