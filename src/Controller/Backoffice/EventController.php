<?php

namespace App\Controller\Backoffice;

use App\Entity\Event;
use DateTimeImmutable;
use App\Form\EventType;
use App\Service\FileUploader;
use App\Repository\EventRepository;
use App\Service\SetAddressDepartment;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("back/event", name="back_event_")
 */
class EventController extends AbstractController
{
    /**
     * @Route("/", name="list", methods={"GET"})
     */
    public function list(EventRepository $eventRepository): Response
    {
        return $this->render('event/list.html.twig', [
            'events' => $eventRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id<\d+>}", name="show", methods={"GET"})
     */
    public function show(Event $event): Response
    {
        return $this->render('event/show.html.twig', [
            'event' => $event,
        ]);
    }

    /**
     * @Route("/create", name="create", methods={"GET", "POST"})
     */
    public function create(Request $request, EventRepository $eventRepository, SetAddressDepartment $setAddressDepartment, FileUploader $fileUploader): Response
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $event->setCreatedAt(new DateTimeImmutable());
      
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // appel du service pour définir les 2 premiers numéro du département en fonction du zipcode
            $setAddressDepartment->setDepartmentFromZipcode($event);

            // gestion de l'image qu'on va upload en BDD
            $pictureFile = $form->get('picture')->getData();

            // gestion de l'image qu'on va upload en BDD
            // on fait appel à un service upload, qui va slug le nom du fichier
            // donner un ID unique à notre image
            // déplacer le fichier dans un dossier public/uploads/xxxxPictures

            if ($pictureFile) {
                $picture = $fileUploader->upload($pictureFile);
                $event->setPicture($picture);
            }

            $eventRepository->add($event, true);
            $this->addFlash('success', 'Événement ajouté !');
            return $this->redirectToRoute('back_event_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('event/create.html.twig', [
            'event' => $event,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id<\d+>}/edit", name="edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Event $event, EventRepository $eventRepository, FileUploader $fileUploader, SetAddressDepartment $setAddressDepartment): Response
    {
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $setAddressDepartment->setDepartmentFromZipcode($event);
            // gestion de l'image qu'on va upload en BDD
            $pictureFile = $form->get('picture')->getData();

            // gestion de l'image qu'on va upload en BDD
            // on fait appel à un service upload, qui va slug le nom du fichier
            // donner un ID unique à notre image
            // déplacer le fichier dans un dossier public/uploads/xxxxPictures

            if ($pictureFile) {
                $picture = $fileUploader->upload($pictureFile);
                $event->setPicture($picture);
            }
            
            $eventRepository->add($event, true);
            $this->addFlash('success', 'Événement ajouté !');
            return $this->redirectToRoute('back_event_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('event/edit.html.twig', [
            'event' => $event,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id<\d+>}", name="delete", methods={"POST"})
     */
    public function delete(Request $request, Event $event, EventRepository $eventRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $event->getId(), $request->request->get('_token'))) {
            $eventRepository->remove($event, true);
        }
        $this->addFlash('success', 'Événement supprimé !');
        return $this->redirectToRoute('back_event_list', [], Response::HTTP_SEE_OTHER);
    }
}
