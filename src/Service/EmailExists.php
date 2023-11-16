<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class EmailExists {

    public function EmailAlreadyExists($entityRepository, $entity) {
        // si l'email existe déjà on veut envoyé un message d'erreur
        // en effet l'email doit être unique donc on va chercher parmis les utilisateurs si l'email existe déjà en BDD
        $emailExist = $entityRepository->findOneBy(['email' => $entity->getEmail()]);
        // si il existe, on envoi une erreur avec une 409, conflict
        if ($emailExist) {
            $errorEmail = [
                'message' => 'Cet email existe déjà !'
            ];
            return new JsonResponse($errorEmail, Response::HTTP_CONFLICT);
        }
    }
}