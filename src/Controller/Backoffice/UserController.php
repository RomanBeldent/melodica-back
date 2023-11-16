<?php

namespace App\Controller\Backoffice;

use App\Entity\User;
use App\Form\UserType;
use DateTimeImmutable;
use App\Service\FileUploader;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
        // affichage de la liste des utilisateurs
        // pour plus de détails se référer à l'API user controller
        return $this->render('user/list.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id<\d+>}", name="show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        // affichage d'un utilisateur spécifique par son ID
        // pour plus de détails se référer à l'API user controller
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/create", name="create", methods={"GET", "POST"})
     */
    public function create(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher, FileUploader $fileUploader): Response
    {
        // on instancie un nouvel objet User
        $user = new User();
        // création d'un formulaire UserType qui se base sur l'objet créé et le formulaire "UserType"
        $form = $this->createForm(UserType::class, $user);
        // on récuère les requêtes, càd les données envoyés dans le formulaire
        $form->handleRequest($request);
        // si le formulaire est soumis et qu'il valide, on lui passe des requêtes customisés
        if ($form->isSubmitted() && $form->isValid()) {
            // on va se servir d'un service pour hasher le mdp
            // on récupère le password en clair de la request
            $clearPassword = $user->getPassword();
            // on stocke dans une variable le password hashé
            $hashedPassword = $passwordHasher->hashPassword($user, $clearPassword);
            // on l'assigne à l'objet user->setPassword qui a été envoyé dans request
            $user->setPassword($hashedPassword);

            // gestion de l'image qu'on va upload en BDD
            // dans le formulaire on veut récupérer les datas envoyé
            // on va avoir besoin notamment du nom de base de l'image (originalName), avec son extension
            $pictureFile = $form->get('picture')->getData();
            // on fait appel à un service upload (FileUploader), qui va :
            // 1 récupérer le nom du fichier sans l'extension
            // 2 slug le nom du fichier
            // 3 donner un ID unique à notre image
            // 4 déplacer le fichier dans un dossier public/uploads/xxxxPictures
            if ($pictureFile) {
                // appel du service upload (se référer à App\Service\FileUploader pour plus de détails)
                $picture = $fileUploader->upload($pictureFile);
                // on envoi le nom de l'image en BDD afin de pouvoir la récupérer dans le dossier public/uploads/pictures
                $user->setPicture($picture);
            }

            // add correspond à persist + flush, le true est une validation
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
        // vu qu'on fait une update, on ajoute un dateTimeImmutable pour avoir l'heure actuelle de la modif
        $user->setUpdatedAt(new DateTimeImmutable());

        // on démappe le champ mdp car on a une gestion spécifique à faire
        $form->add('password', PasswordType::class, [
            'mapped' => false,
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $newPassword = $form->get('password')->getData();
            $pictureFile = $form->get('picture')->getData();

            if ($pictureFile) {
                // on delete l'image si il y en a déjà une
                if (!is_null($user->getPicture())) {
                    // on stock dans une variable le chemin et le nom de l'ancienne image
                    $pictureToBeDeleted = $fileUploader->getTargetDirectory() . '/' . $user->getPicture();
                    // l'image est supprimé grâce à la fonction php unlink
                    unlink($pictureToBeDeleted);
                }
                
                $picture = $fileUploader->upload($pictureFile);
                $user->setPicture($picture);
            }

            if (!is_null($newPassword)) {
                // ('hashage du mot de passe en clair ' . $newPassword);
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
        // doc: https://symfony.com/doc/current/security/csrf.html
        // TWIG génère un token CSRF stocké dans un champ "hidden"
        // on récupère le token CSRF envoyé par TWIG (template/user/_delete_form.html.twig)
        // on vérifie grâce à la fonction isCsrfTokenValid la validité du token
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            // si tout est ok on supprime
            $userRepository->remove($user, true);
        }
        $this->addFlash('success', 'Utilisateur supprimé !');
        return $this->redirectToRoute('back_user_list', [], Response::HTTP_SEE_OTHER);
    }
}
