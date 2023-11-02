<?php

namespace App\Controller\Api;

use App\Entity\Band;
use App\Repository\BandRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/band", name="api_band_")
 */
class BandController extends AbstractController
{
    /**
     * @Route("/", name="list", methods={"GET"})
     */
    public function list(BandRepository $bandRepository): JsonResponse
    {
        return $this->json([
            'bands' => $bandRepository->findAll()], 200, [], ['groups' => 'band_list'
        ]);
    }

    /**
     * @Route("/{id<\d+>}", name="show", methods={"GET"})
     */
    public function show(Band $band): JsonResponse
    {
        return $this->json([
            'band' => $band], 200, [], ['groups' => 'band_show']);
    }
}
