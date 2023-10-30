<?php

namespace App\Controller\Backoffice;

use App\Entity\Type;
use App\Form\TypeType;
use App\Repository\TypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("back/type", name="back_type_")
 */
class TypeController extends AbstractController
{
    /**
     * @Route("/", name="list", methods={"GET"})
     */
    public function list(TypeRepository $typeRepository): Response
    {
        return $this->render('type/list.html.twig', [
            'types' => $typeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/create", name="create", methods={"GET", "POST"})
     */
    public function create(Request $request, TypeRepository $typeRepository): Response
    {
        $type = new Type();
        $form = $this->createForm(TypeType::class, $type);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typeRepository->add($type, true);

            return $this->redirectToRoute('back_type_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type/create.html.twig', [
            'type' => $type,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id<\d+>}", name="show", methods={"GET"})
     */
    public function show(Type $type): Response
    {
        return $this->render('type/show.html.twig', [
            'type' => $type,
        ]);
    }

    /**
     * @Route("/{id<\d+>}/edit", name="edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Type $type, TypeRepository $typeRepository): Response
    {
        $form = $this->createForm(TypeType::class, $type);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typeRepository->add($type, true);

            return $this->redirectToRoute('back_type_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('type/edit.html.twig', [
            'type' => $type,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id<\d+>}", name="delete", methods={"POST"})
     */
    public function delete(Request $request, Type $type, TypeRepository $typeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$type->getId(), $request->request->get('_token'))) {
            $typeRepository->remove($type, true);
        }

        return $this->redirectToRoute('back_type_list', [], Response::HTTP_SEE_OTHER);
    }
}
