<?php

namespace App\Controller\Backoffice;

use App\Entity\Address;
use App\Form\AddressType;
use App\Repository\AddressRepository;
use App\Service\SetAddressDepartment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("back/address", name="back_address_")
 */
class AddressController extends AbstractController
{
    /**
     * @Route("/", name="list", methods={"GET"})
     */
    public function list(AddressRepository $addressRepository): Response
    {
        return $this->render('address/list.html.twig', [
            'addresses' => $addressRepository->findAll(),
        ]);

    }
    /**
     * @Route("/{id<\d+>}", name="show", methods={"GET"})
     */
    public function show(Address $address): Response
    {
        return $this->render('address/show.html.twig', [
            'address' => $address,
        ]);
    }

    /**
     * @Route("/create", name="create", methods={"GET", "POST"})
     */
    public function create(Request $request, AddressRepository $addressRepository, SetAddressDepartment $setAddressDepartment): Response
    {
        $address = new Address();
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);

        //todo gérer les DOM TOM

        if ($form->isSubmitted() && $form->isValid()) {
            $setAddressDepartment->setDepartmentFromZipcode($address);
            $addressRepository->add($address, true);

            $this->addFlash('success', 'Adresse ajouté !');
            return $this->redirectToRoute('back_address_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('address/create.html.twig', [
            'address' => $address,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id<\d+>}/edit", name="edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Address $address, AddressRepository $addressRepository, SetAddressDepartment $setAddressDepartment): Response
    {
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $setAddressDepartment->setDepartmentFromZipcode($address);
            $addressRepository->add($address, true);
            $this->addFlash('success', 'Adresse modifié !');
            return $this->redirectToRoute('back_address_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('address/edit.html.twig', [
            'address' => $address,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id<\d+>}", name="delete", methods={"POST"})
     */
    public function delete(Request $request, Address $address, AddressRepository $addressRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $address->getId(), $request->request->get('_token'))) {
            $addressRepository->remove($address, true);
        }
        $this->addFlash('success', 'Adresse supprimé !');
        return $this->redirectToRoute('back_address_list', [], Response::HTTP_SEE_OTHER);
    }
}
