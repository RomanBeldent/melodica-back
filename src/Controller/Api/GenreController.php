<?php

namespace App\Controller\Api;

use App\Entity\Genre;
use App\Repository\GenreRepository;
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
 * @Route("/api/genre", name="api_genre_")
 */
class GenreController extends AbstractController
{
    /**
     * @Route("/", name="list", methods={"GET"})
     */
    public function list(GenreRepository $genreRepository): JsonResponse
    {
        return $this->json([
            'genres' => $genreRepository->findAll()], 200, [], ['groups' => 'genre_list'
        ]);
    }

    /**
     * @Route("/{id<\d+>}", name="show", methods={"GET"})
     */
    public function show(Genre $genre): JsonResponse
    {
        return $this->json([
            'genre' => $genre], 200, [], ['groups' => 'genre_show']);
    }

        /**
     * @Route("/", name="create", methods={"POST"})
     */
    public function create(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer, ValidatorInterface $validator): JsonResponse
    {
        $json = $request->getContent();
        $genre = $serializer->deserialize($json, Genre::class, 'json');

        $errorList = $validator->validate($genre);
        if (count($errorList) > 0) {
            return $this->json($errorList, Response::HTTP_BAD_REQUEST);
        }

        $entityManager->persist($genre);
        $entityManager->flush();
        return $this->json($genre, Response::HTTP_CREATED, [], ["mailer envoyé"]);
    }

    /**
     * @Route("/{id<\d+>}", name="update", methods={"PATCH"})
     */
    public function update($id, EntityManagerInterface $em, SerializerInterface $serializer, ValidatorInterface $validator, Request $request): JsonResponse
    {
        $genre = $em->find(Genre::class, $id);

        if ($genre === null) {
            $errorMessage = [
                'message' => "Genre not found",
            ];
            return new JsonResponse($errorMessage, Response::HTTP_NOT_FOUND);
        }

        $json = $request->getContent();
        $serializer->deserialize($json, Genre::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $genre]);

        $errorList = $validator->validate($genre);
        if (count($errorList) > 0) {
            return $this->json($errorList, Response::HTTP_BAD_REQUEST);
        }

        $em->flush();
        return $this->json($genre, Response::HTTP_OK, [], ['groups' => 'genre_update']);
    }

    /**
     * @Route("/{id<\d+>}"), name="delete", methods={"DELETE"})
     */
    public function delete($id, EntityManagerInterface $em, GenreRepository $genreRepository)
    {
        $genre = $em->find(Genre::class, $id);

        if ($genre === null) {
            $errorMessage = [
                'message' => "Genre not found",
            ];
            return new JsonResponse($errorMessage, Response::HTTP_NOT_FOUND);
        }

        $genreRepository->remove($genre, true);

        return $this->json($genre, Response::HTTP_OK);
    }
}
