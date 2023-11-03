<?php
namespace App\Controller\Api;
use App\Entity\Type;
use App\Repository\TypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
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
}