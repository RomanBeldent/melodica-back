<?php

namespace App\Controller\Api;

use App\Entity\Favorite;
use App\Repository\FavoriteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/api/favorite", name="api_favorite_")
 */
class FavoriteController extends AbstractController
{
    /**
     * @Route("/", name="list", methods={"GET"})
     */
    public function list(FavoriteRepository $favoriteRepository): JsonResponse
    {
        return $this->json([
            'favorites' => $favoriteRepository->findAll()], 200, [], ['groups' => 'favorite_list'
        ]);
    }

    /**
     * @Route("/{id<\d+>}", name="show", methods={"GET"})
     */
    public function show(Favorite $favorite): JsonResponse
    {
        return $this->json([
            'favorite' => $favorite], 200, [], ['groups' => 'favorite_show']);
    }

    /**
     * @Route("/", name="create", methods={"POST"})
     */
    public function create(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer, ValidatorInterface $validator): JsonResponse
    {
        $json = $request->getContent();
        $favorite = $serializer->deserialize($json, Favorite::class, 'json');

        $errorList = $validator->validate($favorite);
        if (count($errorList) > 0) {
            return $this->json($errorList, Response::HTTP_BAD_REQUEST);
        }

        $entityManager->persist($favorite);
        $entityManager->flush();
        return $this->json($favorite, Response::HTTP_CREATED, [], ["groups" => 'favorite_create']);
    }

    /**
     * @Route("/{id<\d+>}", name="update", methods={"PATCH"})
     */
    public function update($id, EntityManagerInterface $em, SerializerInterface $serializer, ValidatorInterface $validator, Request $request): JsonResponse
    {
        $favorite = $em->find(Favorite::class, $id);

        if ($favorite === null) {
            $errorMessage = [
                'message' => "Favorite not found",
            ];
            return new JsonResponse($errorMessage, Response::HTTP_NOT_FOUND);
        }

        $json = $request->getContent();
        $serializer->deserialize($json, Favorite::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $favorite]);

        $errorList = $validator->validate($favorite);
        if (count($errorList) > 0) {
            return $this->json($errorList, Response::HTTP_BAD_REQUEST);
        }

        $em->flush();
        return $this->json($favorite, Response::HTTP_OK, [], ['groups' => 'favorite_update']);
    }

    /**
     * @Route("/{id<\d+>}"), name="delete", methods={"DELETE"})
     */
    public function delete($id, EntityManagerInterface $em, FavoriteRepository $favoriteRepository)
    {
        $favorite = $em->find(Favorite::class, $id);

        if ($favorite === null) {
            $errorMessage = [
                'message' => "Favorite not found",
            ];
            return new JsonResponse($errorMessage, Response::HTTP_NOT_FOUND);
        }

        $favoriteRepository->remove($favorite, true);

        return $this->json($favorite, Response::HTTP_OK);
    }
}
