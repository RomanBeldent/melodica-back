<?php

namespace App\Controller\Api;

use App\Entity\Event;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/event", name="api_event_")
 */
class EventController extends AbstractController
{
    /**
     * @Route("/", name="list", methods={"GET"})
     */
    public function list(EventRepository $eventRepository): JsonResponse
    {
        return $this->json([
            'events' => $eventRepository->findAll()], 200, [], ['groups' => 'event_list'
        ]);
    }

    /**
     * @Route("/{id<\d+>}", name="show", methods={"GET"})
     */
    public function show(Event $event): JsonResponse
    {
        return $this->json([
            'event' => $event], 200, [], ['groups' => 'event_show']);
    }
}
