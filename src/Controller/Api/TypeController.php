<?php

namespace App\Controller\Api;

use App\Entity\Type;
use App\Repository\TypeRepository;
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
 * @Route("/api/type", name="api_type_")
 */
class TypeController extends AbstractController
{
    /**
     * @Route("/", name="list", methods={"GET"})
     */
    public function list(TypeRepository $typeRepository): JsonResponse
    {
        return $this->json([
            'types' => $typeRepository->findAll()], 200, [], ['groups' => 'type_list'
        ]);
    }

    /**
     * @Route("/{id<\d+>}", name="show", methods={"GET"})
     */
    public function show(Type $type): JsonResponse
    {
        return $this->json([
            'type' => $type], 200, [], ['groups' => 'type_show']);
    }

    /**
     * @Route("/", name="create", methods={"POST"})
     */
    public function create(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer, ValidatorInterface $validator): JsonResponse
    {
        $json = $request->getContent();
        $type = $serializer->deserialize($json, Type::class, 'json');

        $errorList = $validator->validate($type);
        if (count($errorList) > 0) {
            return $this->json($errorList, Response::HTTP_BAD_REQUEST);
        }

        $entityManager->persist($type);
        $entityManager->flush();
        return $this->json($type, Response::HTTP_CREATED, [], ["groups" => 'type_create']);
    }

    /**
     * @Route("/{id<\d+>}", name="update", methods={"PATCH"})
     */
    public function update($id, EntityManagerInterface $em, SerializerInterface $serializer, ValidatorInterface $validator, Request $request): JsonResponse
    {
        $type = $em->find(Type::class, $id);

        if ($type === null) {
            $errorMessage = [
                'message' => "Type not found",
            ];
            return new JsonResponse($errorMessage, Response::HTTP_NOT_FOUND);
        }

        $json = $request->getContent();
        $serializer->deserialize($json, Type::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $type]);

        $errorList = $validator->validate($type);
        if (count($errorList) > 0) {
            return $this->json($errorList, Response::HTTP_BAD_REQUEST);
        }

        $em->flush();
        return $this->json($type, Response::HTTP_OK, [], ['groups' => 'type_update']);
    }

    /**
     * @Route("/{id<\d+>}"), name="delete", methods={"DELETE"})
     */
    public function delete($id, EntityManagerInterface $em, TypeRepository $typeRepository)
    {
        $type = $em->find(Type::class, $id);

        if ($type === null) {
            $errorMessage = [
                'message' => "Type not found",
            ];
            return new JsonResponse($errorMessage, Response::HTTP_NOT_FOUND);
        }

        $typeRepository->remove($type, true);

        return $this->json($type, Response::HTTP_OK);
    }
}
