<?php
namespace App\Controller\Api;
use App\Entity\Favorite;
use App\Repository\FavoriteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
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
}