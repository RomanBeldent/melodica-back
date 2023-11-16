<?php

namespace App\Controller\Api;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/api/mailer", name="api_mailer_")
 */
class MailerController extends AbstractController
{
    /**
     * @Route("/", name="send", methods={"POST"})
     */
    public function sendMail(Request $request, MailerInterface $mailer): Response
    {
        // on décode le json avec la fonction PHP
        // ce json est la requête qu'envoi l'utilisateur depuis le front
        // on récupère l'email de l'utilisateur connecté, le contenu du message qu'il veut envoyer à l'orga ou au groupe, et l'id du destinataire
        $json = json_decode($request->getContent());
        
        $email = (new TemplatedEmail())
            ->from($json->email)
            // email du destinataire (band{id} ou organizer{id})
            ->to($json->recipientEmail)
            ->subject('Vous avez reçu un message de la part d\'un utilisateur de Mélodica !')
            // import du template
            ->htmlTemplate('mailer/body.html.twig')
            // le contenu du message envoyé par l'utilisateur
            ->context(['body'=>$json->body]);

        $mailer->send($email);

        return $this->json('Email envoyé', Response::HTTP_OK);
    }
}
