<?php

namespace App\Controller\Api;

use App\Entity\User;
use DateTimeImmutable;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @Route("/api/user", name="api_user_")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="list", methods={"GET"})
     */
    public function list(UserRepository $userRepository): JsonResponse
    {
        // doc: https://symfony.com/doc/current/doctrine.html#fetching-objects-from-the-database
        // grâce à Doctrine, on peut récupérer facilement une liste de données, ou même une donnée précise (méthode show)
        // avec la méthode findAll qui est directement intégré dans l'ORM doctrine
        // il va chercher dans le répertoire utilisateur qui est relié à l'entité User (anciennement appelé Objet)
        // tous les utilisateurs dans notre BDD (DATABASE_URL dans .env.local)
        // vu que nous sommes dans un controller API: 
        // 1. on retourne du json avec les datas de tous les users
        // 2. on lui assigne un code HTTP 200 OK
        // 3. pour finir on assigne un groupe qui va nous servir à choisir ce que l'on veut afficher comme données dans le retour json
        // ces groupes sont définit dans les entités avec des annotations -> ex: @Groups({"user_list"})
        // ces données serviront au FRONT et il est très facilement possible de choisir et modifier ce que l'on veut envoyer
        return $this->json([
            'users' => $userRepository->findAll()], 200, [], ['groups' => 'user_list'
        ]);
    }

    /**
     * @Route("/{id<\d+>}", name="show", methods={"GET"})
     */
    public function show(User $user): JsonResponse
    {
        // la méthode show va chercher les datas de l'utilisateur correspondant à l'ID dans l'url
        // grâce à la magie de doctrine on peut directement allé chercher dans l'entité User 
        // il va nous retrouver l'ID qu'on a rentré en paramètre de route en annotations (@Route("{id<\d+>}))
        // cette annotation veut dire qu'on attend un chiffre positif à tout prix (regex)
        // on peut aussi le rentrer de cette manière {id}, mais ça peut créer des conflits si on utilise un string au lieu d'un integer
        // de cette façon on peut avoir une route user/integer, et une route user/string sans conflit
        return $this->json([
            'user' => $user], 200, [], ['groups' => 'user_show']);
    }

    /**
     * @Route("/", name="create", methods={"POST"})
     */
    public function create(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer, ValidatorInterface $validator, UserPasswordHasherInterface $passwordHasher, UserRepository $userRepository): JsonResponse
    {
        // on récupère la requête json
        $json = $request->getContent();
        // on deserialize cette dernière qu'on va directement stocker dans l'objet User
        $user = $serializer->deserialize($json, User::class, 'json');

        // on récupère le mdp en clair, on le hash. Voir les commentaires dans Backoffice\UserController.php
        $clearPassword = $user->getPassword();
        $hashedPassword = $passwordHasher->hashPassword($user, $clearPassword);
        $user->setPassword($hashedPassword);
        $this->addFlash('success', 'Utilisateur ajouté !');
        // si l'email existe déjà on veut envoyé un message d'erreur
        // en effet l'email doit être unique donc on va chercher parmis les utilisateurs si l'email existe déjà en BDD
        $emailExist = $userRepository->findOneBy(['email' => $user->getEmail()]);

        // si il existe, on envoi une erreur avec une 409, conflict
        if ($emailExist) {
            $errorEmail = [
                'message' => 'Cet email existe déjà !'
            ];
            return new JsonResponse($errorEmail, Response::HTTP_CONFLICT);
        }

        // si il y a une erreur dans la requête on envoi un erreur 400, bad request
        $errorList = $validator->validate($user);
        if (count($errorList) > 0) {
            return $this->json($errorList, Response::HTTP_BAD_REQUEST);
        }

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->json($user, Response::HTTP_CREATED, [], ["groups" => 'user_create']);
    }

    /**
     * @Route("/{id<\d+>}", name="update", methods={"PATCH"})
     */
    public function update($id, EntityManagerInterface $em, SerializerInterface $serializer, ValidatorInterface $validator, Request $request): JsonResponse
    {
        // on récupère l'id de l'user qu'on veut modifier
        $user = $em->find(User::class, $id);
        // on ajoute la date de modification
        $user->setUpdatedAt(new DateTimeImmutable());

        if ($user === null) {
            $errorMessage = [
                'message' => "User not found",
            ];
            return new JsonResponse($errorMessage, Response::HTTP_NOT_FOUND);
        }
        // on récupère le contenu de la requête en JSON qu'on va deserializer
        $json = $request->getContent();
        // on deserialize, c'est un objet de User, et on va vouloir insérer les nvelles data dans l'utilisateur selectionné 
        $serializer->deserialize($json, User::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $user]);

        $errorList = $validator->validate($user);
        if (count($errorList) > 0) {
            return $this->json($errorList, Response::HTTP_BAD_REQUEST);
        }

        $em->flush();
        return $this->json($user, Response::HTTP_OK, [], ['groups' => 'user_update']);
    }

    /**
     * @Route("/{id<\d+>}"), name="delete", methods={"DELETE"})
     */
    public function delete($id, EntityManagerInterface $em, UserRepository $userRepository)
    {
        $user = $em->find(User::class, $id);

        if ($user === null) {
            $errorMessage = [
                'message' => "User not found",
            ];
            return new JsonResponse($errorMessage, Response::HTTP_NOT_FOUND);
        }

        $userRepository->remove($user, true);

        return $this->json($user, Response::HTTP_OK);
    }
}
