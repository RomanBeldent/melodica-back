<?php

namespace App\Controller\Backoffice;

use App\Entity\Organizer;
use App\Form\OrganizerType;
use App\Repository\OrganizerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("back/organizer", name="back_organizer_")
 */
class OrganizerController extends AbstractController
{
    /**
     * @Route("/", name="list", methods={"GET"})
     */
    public function list(OrganizerRepository $organizerRepository): Response
    {
        return $this->render('organizer/list.html.twig', [
            'organizers' => $organizerRepository->findAll(),
        ]);
    }

    /**
     * @Route("/create", name="create", methods={"GET", "POST"})
     */
    public function create(Request $request, OrganizerRepository $organizerRepository): Response
    {
        $organizer = new Organizer();
        $form = $this->createForm(OrganizerType::class, $organizer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $organizerRepository->add($organizer, true);

            return $this->redirectToRoute('back_organizer_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('organizer/create.html.twig', [
            'organizer' => $organizer,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id<\d+>}", name="show", methods={"GET"})
     */
    public function show(Organizer $organizer): Response
    {
        return $this->render('organizer/show.html.twig', [
            'organizer' => $organizer,
        ]);
    }

    /**
     * @Route("/{id<\d+>}/edit", name="edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Organizer $organizer, OrganizerRepository $organizerRepository): Response
    {
        $form = $this->createForm(OrganizerType::class, $organizer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $organizerRepository->add($organizer, true);

            return $this->redirectToRoute('back_organizer_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('organizer/edit.html.twig', [
            'organizer' => $organizer,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id<\d+>}", name="delete", methods={"POST"})
     */
    public function delete(Request $request, Organizer $organizer, OrganizerRepository $organizerRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$organizer->getId(), $request->request->get('_token'))) {
            $organizerRepository->remove($organizer, true);
        }

        return $this->redirectToRoute('back_organizer_list', [], Response::HTTP_SEE_OTHER);
    }
}
