<?php

namespace App\Controller\Backoffice;

use DateTimeImmutable;
use App\Entity\Organizer;
use App\Form\OrganizerType;
use App\Service\FileUploader;
use App\Repository\OrganizerRepository;
use App\Service\SetAddressDepartment;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
     * @Route("/{id<\d+>}", name="show", methods={"GET"})
     */
    public function show(Organizer $organizer): Response
    {
        return $this->render('organizer/show.html.twig', [
            'organizer' => $organizer,
        ]);
    }

    /**
     * @Route("/create", name="create", methods={"GET", "POST"})
     */
    public function create(Request $request, OrganizerRepository $organizerRepository, SetAddressDepartment $setAddressDepartment, FileUploader $fileUploader): Response
    {
        $organizer = new Organizer();

        $form = $this->createForm(OrganizerType::class, $organizer);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // appel du service pour définir les 2 premiers numéro du département en fonction du zipcode
            $setAddressDepartment->setDepartmentFromZipcode($organizer);

            // gestion de l'image qu'on va upload en BDD
            $pictureFile = $form->get('picture')->getData();
            // gestion de l'image qu'on va upload en BDD
            // on fait appel à un service upload, qui va slug le nom du fichier
            // donner un ID unique à notre image
            // déplacer le fichier dans un dossier public/uploads/xxxxPictures

            if ($pictureFile) {

                $picture = $fileUploader->upload($pictureFile);
                $organizer->setPicture($picture);
            }

            $organizerRepository->add($organizer, true);
            foreach($form->get('type')->getData() as $currentType) {
                // on modifie les relations entre movie et genre
                $currentType->addOrganizer($organizer);
            }
            $this->addFlash('success', 'Organisateur ajouté !');
            return $this->redirectToRoute('back_organizer_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('organizer/create.html.twig', [
            'organizer' => $organizer,
            'form' => $form,
        ]);
    }


    /**
     * @Route("/{id<\d+>}/edit", name="edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Organizer $organizer, OrganizerRepository $organizerRepository, FileUploader $fileUploader, SetAddressDepartment $setAddressDepartment): Response
    {
        $form = $this->createForm(OrganizerType::class, $organizer);

        $organizer->setUpdatedAt(new DateTimeImmutable());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $setAddressDepartment->setDepartmentFromZipcode($organizer);
            // gestion de l'image qu'on va upload en BDD
            $pictureFile = $form->get('picture')->getData();

            // gestion de l'image qu'on va upload en BDD
            // on fait appel à un service upload, qui va slug le nom du fichier
            // donner un ID unique à notre image
            // déplacer le fichier dans un dossier public/uploads/xxxxPictures

            if ($pictureFile) {
                $fileUploader->delete($organizer);
                $picture = $fileUploader->upload($pictureFile);
                $organizer->setPicture($picture);
            }

            $organizerRepository->add($organizer, true);
            $this->addFlash('success', 'Organisateur modifié !');
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
        if ($this->isCsrfTokenValid('delete' . $organizer->getId(), $request->request->get('_token'))) {
            $organizerRepository->remove($organizer, true);
        }
        $this->addFlash('success', 'Organisateur supprimé !');
        return $this->redirectToRoute('back_organizer_list', [], Response::HTTP_SEE_OTHER);
    }
}
