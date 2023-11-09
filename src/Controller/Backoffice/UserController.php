<?php

namespace App\Controller\Backoffice;

use App\Entity\User;
use App\Form\UserType;
use DateTimeImmutable;
use App\Service\FileUploader;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @Route("back/user", name="back_user_")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="list", methods={"GET"})
     */
    public function list(UserRepository $userRepository): Response
    {
        return $this->render('user/list.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id<\d+>}", name="show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/create", name="create", methods={"GET", "POST"})
     */
    public function create(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher, FileUploader $fileUploader): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $user->setCreatedAt(new DateTimeImmutable());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //password hashing
            $clearPassword = $user->getPassword();
            $hashedPassword = $passwordHasher->hashPassword($user, $clearPassword);
            $user->setPassword($hashedPassword);

            // gestion de l'image qu'on va upload en BDD
            $pictureFile = $form->get('picture')->getData();

            // gestion de l'image qu'on va upload en BDD
            // on fait appel à un service upload, qui va slug le nom du fichier
            // donner un ID unique à notre image
            // déplacer le fichier dans un dossier public/uploads/xxxxPictures

            if ($pictureFile) {
                $pictureFilename = $fileUploader->upload($pictureFile);
                $user->setPictureFilename($pictureFilename);
            }

            $userRepository->add($user, true);
            $this->addFlash('success', 'Utilisateur ajouté !');
            return $this->redirectToRoute('back_user_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/create.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id<\d+>}/edit", name="edit", methods={"GET", "POST"})
     *
     */
    public function edit(UserPasswordHasherInterface $passwordHasher, Request $request, User $user, UserRepository $userRepository, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $user->setUpdatedAt(new DateTimeImmutable());

        // on démappe le champ mdp car on a une gestion spécifique à faire
        $form->add('password', PasswordType::class, [
            'mapped' => false,
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $newPassword = $form->get('password')->getData();
            $pictureFile = $form->get('picture')->getData();
            
            // gestion de l'image qu'on va upload en BDD
            // on fait appel à un service upload, qui va slug le nom du fichier
            // donner un ID unique à notre image
            // déplacer le fichier dans un dossier public/uploads/xxxxPictures

            if ($pictureFile) {
                $pictureFilename = $fileUploader->upload($pictureFile);
                $user->setPictureFilename($pictureFilename);
            }
            
            if (!is_null($newPassword)) {
                //('hashage du mot de passe en clair ' . $newPassword);
                $hashedPassword = $passwordHasher->hashPassword($user, $newPassword);
                $user->setPassword($hashedPassword);


            } else {
                // on ne fait rien et l'ancien mot qui était en BDD est conservé
            }
            $userRepository->add($user, true);
            $this->addFlash('success', 'Utilisateur modifié');
            return $this->redirectToRoute('back_user_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id<\d+>}", name="delete", methods={"POST"})
     */
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }
        $this->addFlash('success', 'Utilisateur supprimé !');
        return $this->redirectToRoute('back_user_list', [], Response::HTTP_SEE_OTHER);
    }
}
