<?php

namespace App\Controller\Api;

use App\Entity\Organizer;
use App\Repository\OrganizerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/organizer", name="api_organizer_")
 */
class OrganizerController extends AbstractController
{
    /**
     * @Route("/", name="list", methods={"GET"})
     */
    public function list(OrganizerRepository $organizerRepository): JsonResponse
    {
        return $this->json([
            'organizers' => $organizerRepository->findAll()], 200, [], ['groups' => 'organizer_list'
        ]);
    }

    /**
     * @Route("/{id<\d+>}", name="show", methods={"GET"})
     */
    public function show(Organizer $organizer): JsonResponse
    {
        return $this->json([
            'organizer' => $organizer], 200, [], ['groups' => 'organizer_show']);
    }
}
