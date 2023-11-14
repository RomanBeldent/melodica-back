<?php

namespace App\Controller\Api;

use App\Entity\Band;
use App\Entity\User;
use App\Entity\Organizer;
use Symfony\Component\Mime\Email;
use App\Repository\OrganizerRepository;
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
    public function sendEmail(Request $request, MailerInterface $mailer, Organizer $organizer, Band $band): Response
    {
        
        $email = $_SESSION['_sf2_attributes']['_security.last_username'];
        $_SESSION['email'] = $email;

        $content = $request->request->get('content');

        if ($organizer->getUsers()[0]->getEmail()) {
            $bandOrOrganizer = $organizer;
        } else {
                    $bandOrOrganizer = $band;
                }

        $email = (new Email())
            ->from($_SESSION['email'])
            ->to($bandOrOrganizer->getUsers()[0]->getEmail())
            ->subject('Vous avez reçu un message de la part d\'un utilisateur de Mélodica !')
            ->text($content)
            ->html('<p>' . nl2br($content) . '</p>');

        $mailer->send($email);
        
        return $this->json('Email envoyé', Response::HTTP_OK);
    }
}
