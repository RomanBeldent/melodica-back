<?php

namespace App\Controller\Api;

use App\Entity\Event;
use DateTimeImmutable;
use App\Repository\EventRepository;
use App\Service\SetAddressDepartment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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

    /**
     * @Route("/", name="create", methods={"POST"})
     */
    public function create(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer, ValidatorInterface $validator, SetAddressDepartment $setAddressDepartment): JsonResponse
    {
        $json = $request->getContent();
        $event = $serializer->deserialize($json, Event::class, 'json');

        $setAddressDepartment->setDepartmentFromZipcode($event);

        $errorList = $validator->validate($event);
        if (count($errorList) > 0) {
            return $this->json($errorList, Response::HTTP_BAD_REQUEST);
        }

        $entityManager->persist($event);
        $entityManager->flush();
        return $this->json($event, Response::HTTP_CREATED, [], ["groups" => 'event_create']);
    }

    /**
     * @Route("/{id<\d+>}", name="update", methods={"PATCH"})
     */
    public function update($id, EntityManagerInterface $em, SerializerInterface $serializer, ValidatorInterface $validator, Request $request, SetAddressDepartment $setAddressDepartment): JsonResponse
    {
        $event = $em->find(Event::class, $id);
        $event->setUpdatedAt(new DateTimeImmutable());

        if ($event === null) {
            $errorMessage = [
                'message' => "Event not found",
            ];
            return new JsonResponse($errorMessage, Response::HTTP_NOT_FOUND);
        }

        $json = $request->getContent();
        $serializer->deserialize($json, Event::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $event]);

        $setAddressDepartment->setDepartmentFromZipcode($event);

        $errorList = $validator->validate($event);
        if (count($errorList) > 0) {
            return $this->json($errorList, Response::HTTP_BAD_REQUEST);
        }

        $em->flush();
        return $this->json($event, Response::HTTP_OK, [], ['groups' => 'event_update']);
    }

    /**
     * @Route("/{id<\d+>}"), name="delete", methods={"DELETE"})
     */
    public function delete($id, EntityManagerInterface $em, EventRepository $eventRepository)
    {
        $event = $em->find(Event::class, $id);

        if ($event === null) {
            $errorMessage = [
                'message' => "Event not found",
            ];
            return new JsonResponse($errorMessage, Response::HTTP_NOT_FOUND);
        }

        $eventRepository->remove($event, true);

        return $this->json($event, Response::HTTP_OK);
    }
}
