<?php

namespace App\Controller\Api;

use App\Entity\Address;
use App\Repository\AddressRepository;
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
 * @Route("/api/address", name="api_address_")
 */
class AddressController extends AbstractController
{
    /**
     * @Route("/", name="list", methods={"GET"})
     */
    public function list(AddressRepository $addressRepository): JsonResponse
    {
        return $this->json([
            'addresses' => $addressRepository->findAll()], 200, [], ['groups' => 'address_list'
        ]);
    }

    /**
     * @Route("/{id<\d+>}", name="show", methods={"GET"})
     */
    public function show(Address $address): JsonResponse
    {
        return $this->json([
            'address' => $address], 200, [], ['groups' => 'address_show']);
    }
    /**
     * @Route("/", name="create", methods={"POST"})
     */
    public function create(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer, ValidatorInterface $validator): JsonResponse
    {
        $json = $request->getContent();
        $address = $serializer->deserialize($json, Address::class, 'json');
        $errorList = $validator->validate($address);
        if (count($errorList) > 0) {
            return $this->json($errorList, Response::HTTP_BAD_REQUEST);
        }
        $entityManager->persist($address);
        $entityManager->flush();
        return $this->json($address, Response::HTTP_CREATED, [], ["groups" => 'address_create']);
    }
    /**
     * @Route("/{id<\d+>}", name="update", methods={"PUT"})
     */
    public function update($id, EntityManagerInterface $em, SerializerInterface $serializer, ValidatorInterface $validator, Request $request): JsonResponse
    {
        $address = $em->find(Address::class, $id);
        if ($address === null) {
            $errorMessage = [
                'message' => "Address not found",
            ];
            return new JsonResponse($errorMessage, Response::HTTP_NOT_FOUND);
        }
        $json = $request->getContent();
        $serializer->deserialize($json, Address::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $address]);
        $errorList = $validator->validate($address);
        if (count($errorList) > 0) {
            return $this->json($errorList, Response::HTTP_BAD_REQUEST);
        }
        $em->flush();
        return $this->json($address, Response::HTTP_OK, [], ['groups' => 'address_update']);
    }
    /**
     * @Route("/{id<\d+>}"), name="delete", methods={"DELETE"})
     */
    public function delete($id, EntityManagerInterface $em, AddressRepository $addressRepository)
    {
        $address = $em->find(Address::class, $id);
        if ($address === null) {
            $errorMessage = [
                'message' => "Address not found",
            ];
            return new JsonResponse($errorMessage, Response::HTTP_NOT_FOUND);
        }
        $addressRepository->remove($address, true);
        return $this->json($address, Response::HTTP_OK);
    }
}
