<?php

namespace App\Controller\Backoffice;

use App\Entity\Band;
use App\Form\BandType;
use DateTimeImmutable;
use App\Service\FileUploader;
use App\Repository\BandRepository;
use App\Service\SetAddressDepartment;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("back/band", name="back_band_")
 */
class BandController extends AbstractController
{
    /**
     * @Route("/", name="list", methods={"GET"})
     */
    public function list(BandRepository $bandRepository): Response
    {
        return $this->render('band/list.html.twig', [
            'bands' => $bandRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id<\d+>}", name="show", methods={"GET"})
     */
    public function show(Band $band): Response
    {
        return $this->render('band/show.html.twig', [
            'band' => $band,
        ]);
    }

    /**
     * @Route("/create", name="create", methods={"GET", "POST"})
     */
    public function create(Request $request, BandRepository $bandRepository, SetAddressDepartment $setAddressDepartment, FileUploader $fileUploader): Response
    {
        $band = new Band();
        $form = $this->createForm(BandType::class, $band);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // appel du service pour définir les 2 premiers numéro du département en fonction du zipcode
            $setAddressDepartment->setDepartmentFromZipcode($band);

            $pictureFile = $form->get('picture')->getData();

            // gestion de l'image qu'on va upload en BDD
            // on fait appel à un service upload, qui va slug le nom du fichier
            // donner un ID unique à notre image
            // déplacer le fichier dans un dossier public/uploads/xxxxPictures

            if ($pictureFile) {
                $picture = $fileUploader->upload($pictureFile);
                $band->setPicture($picture);
            }

            $bandRepository->add($band, true);
            $this->addFlash('success', 'Groupe ajouté !');
            return $this->redirectToRoute('back_band_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('band/create.html.twig', [
            'band' => $band,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id<\d+>}/edit", name="edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Band $band, BandRepository $bandRepository, FileUploader $fileUploader, SetAddressDepartment $setAddressDepartment): Response
    {
        $form = $this->createForm(BandType::class, $band);
        $band->setUpdatedAt(new DateTimeImmutable());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //
            $setAddressDepartment->setDepartmentFromZipcode($band);
            // 
            $pictureFile = $form->get('picture')->getData();

            // gestion de l'image qu'on va upload en BDD
            // on fait appel à un service upload, qui va slug le nom du fichier
            // donner un ID unique à notre image
            // déplacer le fichier dans un dossier public/uploads/xxxxPictures

            if ($pictureFile) {
                // on delete l'image si il y en a déjà une
                $fileUploader->delete($band);
                $picture = $fileUploader->upload($pictureFile);
                $band->setPicture($picture);
            }

            $bandRepository->add($band, true);
            $this->addFlash('success', 'Groupe modifié !');
            return $this->redirectToRoute('back_band_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('band/edit.html.twig', [
            'band' => $band,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id<\d+>}", name="delete", methods={"POST"})
     */
    public function delete(Request $request, Band $band, BandRepository $bandRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $band->getId(), $request->request->get('_token'))) {
            $bandRepository->remove($band, true);
        }
        $this->addFlash('success', 'Groupe supprimé !');
        return $this->redirectToRoute('back_band_list', [], Response::HTTP_SEE_OTHER);
    }
}
