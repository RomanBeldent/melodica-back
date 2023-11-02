<?php

namespace App\Controller\Api;

use App\Entity\Tag;
use App\Repository\TagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

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
}
