<?php

namespace App\Controller\Api;

use App\Entity\Tag;
use App\Repository\TagRepository;
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
 * @Route("/api/tag", name="api_tag_")
 */
class TagController extends AbstractController
{
    /**
     * @Route("/", name="list", methods={"GET"})
     */
    public function list(TagRepository $tagRepository): JsonResponse
    {
        return $this->json([
            'tags' => $tagRepository->findAll()], 200, [], ['groups' => 'tag_list'
        ]);
    }

    /**
     * @Route("/{id<\d+>}", name="show", methods={"GET"})
     */
    public function show(Tag $tag): JsonResponse
    {
        return $this->json([
            'tag' => $tag], 200, [], ['groups' => 'tag_show']);
    }

    /**
     * @Route("/", name="create", methods={"POST"})
     */
    public function create(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer, ValidatorInterface $validator): JsonResponse
    {
        $json = $request->getContent();
        $tag = $serializer->deserialize($json, Tag::class, 'json');

        $errorList = $validator->validate($tag);
        if (count($errorList) > 0) {
            return $this->json($errorList, Response::HTTP_BAD_REQUEST);
        }

        $entityManager->persist($tag);
        $entityManager->flush();
        return $this->json($tag, Response::HTTP_CREATED, [], ["groups" => 'tag_create']);
    }

    /**
     * @Route("/{id<\d+>}", name="update", methods={"PATCH"})
     */
    public function update($id, EntityManagerInterface $em, SerializerInterface $serializer, ValidatorInterface $validator, Request $request): JsonResponse
    {
        $tag = $em->find(Tag::class, $id);

        if ($tag === null) {
            $errorMessage = [
                'message' => "Tag not found",
            ];
            return new JsonResponse($errorMessage, Response::HTTP_NOT_FOUND);
        }

        $json = $request->getContent();
        $serializer->deserialize($json, Tag::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $tag]);

        $errorList = $validator->validate($tag);
        if (count($errorList) > 0) {
            return $this->json($errorList, Response::HTTP_BAD_REQUEST);
        }

        $em->flush();
        return $this->json($tag, Response::HTTP_OK, [], ['groups' => 'tag_update']);
    }

    /**
     * @Route("/{id<\d+>}"), name="delete", methods={"DELETE"})
     */
    public function delete($id, EntityManagerInterface $em, TagRepository $tagRepository)
    {
        $tag = $em->find(Tag::class, $id);

        if ($tag === null) {
            $errorMessage = [
                'message' => "Tag not found",
            ];
            return new JsonResponse($errorMessage, Response::HTTP_NOT_FOUND);
        }

        $tagRepository->remove($tag, true);

        return $this->json($tag, Response::HTTP_OK);
    }

}
