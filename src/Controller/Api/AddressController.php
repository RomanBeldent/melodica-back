<?php

namespace App\Controller\Api;

use App\Entity\Address;
use App\Repository\AddressRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

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
}
