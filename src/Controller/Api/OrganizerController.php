<?php

namespace App\Controller\Api;

use App\Entity\Organizer;
use App\Repository\OrganizerRepository;
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

    /**
     * @Route("/", name="create", methods={"POST"})
     */
    public function create(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer, ValidatorInterface $validator): JsonResponse
    {
        $json = $request->getContent();
        $organizer = $serializer->deserialize($json, Organizer::class, 'json');

        $errorList = $validator->validate($organizer);
        if (count($errorList) > 0) {
            return $this->json($errorList, Response::HTTP_BAD_REQUEST);
        }

        $entityManager->persist($organizer);
        $entityManager->flush();
        return $this->json($organizer, Response::HTTP_CREATED, [], ["groups" => 'organizer_create']);
    }

    /**
     * @Route("/{id<\d+>}", name="update", methods={"PATCH"})
     */
    public function update($id, EntityManagerInterface $em, SerializerInterface $serializer, ValidatorInterface $validator, Request $request): JsonResponse
    {
        $organizer = $em->find(Organizer::class, $id);

        if ($organizer === null) {
            $errorMessage = [
                'message' => "Organizer not found",
            ];
            return new JsonResponse($errorMessage, Response::HTTP_NOT_FOUND);
        }

        $json = $request->getContent();
        $serializer->deserialize($json, Organizer::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $organizer]);

        $errorList = $validator->validate($organizer);
        if (count($errorList) > 0) {
            return $this->json($errorList, Response::HTTP_BAD_REQUEST);
        }

        $em->flush();
        return $this->json($organizer, Response::HTTP_OK, [], ['groups' => 'organizer_update']);
    }

    /**
     * @Route("/{id<\d+>}"), name="delete", methods={"DELETE"})
     */
    public function delete($id, EntityManagerInterface $em, OrganizerRepository $organizerRepository)
    {
        $organizer = $em->find(Organizer::class, $id);

        if ($organizer === null) {
            $errorMessage = [
                'message' => "Organizer not found",
            ];
            return new JsonResponse($errorMessage, Response::HTTP_NOT_FOUND);
        }

        $organizerRepository->remove($organizer, true);

        return $this->json($organizer, Response::HTTP_OK);
    }
}
