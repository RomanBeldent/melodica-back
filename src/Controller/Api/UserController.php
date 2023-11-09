<?php

namespace App\Controller\Api;

use App\Entity\User;
use DateTimeImmutable;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Config\Security\FirewallConfig\JwtConfig;

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
        return $this->json([
            'users' => $userRepository->findAll()], 200, [], ['groups' => 'user_list'
        ]);
    }

    /**
     * @Route("/{id<\d+>}", name="show", methods={"GET"})
     */
    public function show(User $user): JsonResponse
    {
        return $this->json([
            'user' => $user], 200, [], ['groups' => 'user_show']);
    }

    /**
     * @Route("/", name="create", methods={"POST"})
     */
    public function create(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer, ValidatorInterface $validator, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        $json = $request->getContent();
        $user = $serializer->deserialize($json, User::class, 'json');

        $clearPassword = $user->getPassword();
        $hashedPassword = $passwordHasher->hashPassword($user, $clearPassword);
        $user->setPassword($hashedPassword);
        $this->addFlash('success', 'Utilisateur ajouté !');
        $emailExist = $userRepository->findOneBy(['email' => $user->getEmail()]);

        if ($emailExist) {
            $errorEmail = [
                'message' => 'Cet email existe déjà !'
            ];
            return new JsonResponse($errorEmail, Response::HTTP_CONFLICT);
        }

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
        $user = $em->find(User::class, $id);
        $user->setUpdatedAt(new DateTimeImmutable());

        if ($user === null) {
            $errorMessage = [
                'message' => "User not found",
            ];
            return new JsonResponse($errorMessage, Response::HTTP_NOT_FOUND);
        }

        $json = $request->getContent();
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
