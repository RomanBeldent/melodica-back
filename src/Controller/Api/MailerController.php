<?php

namespace App\Controller\Api;

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

        $json = json_decode($request->getContent());
        // dd($json->email);
        // dd($json);

        $email = (new Email())
            ->from($json->email)
            ->to($json->recipientEmail)
            ->subject('Vous avez reçu un message de la part d\'un utilisateur de Mélodica !')
            // ->text($json->body)
            ->html('<p>' . nl2br($json->body) . '</p>');

        $mailer->send($email);

        return $this->json('Email envoyé', Response::HTTP_OK);
    }
}
