<?php

namespace App\Controller\Api;

use App\Entity\Genre;
use App\Repository\GenreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

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
}
