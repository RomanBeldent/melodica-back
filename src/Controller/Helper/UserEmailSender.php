<?php 

namespace App\Helper;

use App\Entity\Answer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class UserEmailSender
{

    private $symfonyMailer;
    private $fromEmail;

    public function __construct(MailerInterface $mailerInterface, $fromEmail)
    {
        $this->symfonyMailer = $mailerInterface;
        $this->fromEmail = $fromEmail;
    }

    /**
     * Send an email when an answer is added to a question
     *
     * @param Answer $answer
     * @return void
     */
    public function sendNewAnswerAvailableMail(Answer $answer) :void
    {
        // récupérer la réponse qui a été fournie
        // récupérer la question correspondant à cette réponse
        $question = $answer->getQuestion();
        // récupérer l'utilisateur qui a écrit cette question
        $userCreator = $question->getUser();

        $email = (new Email())
            ->from($this->fromEmail)
            ->to($userCreator->getEmail())
            
            ->cc($answer->getUser()->getEmail())
            ->bcc($this->fromEmail)
            ->subject('Une réponse a été ajoutée à votre question ' . $question->getId())
            // pour utiliser un template twig cf : https://symfony.com/doc/5.4/mailer.html#html-content
            ->text($answer->getBody())
            ->html('<h1>La réponse!</h1><p>' . $answer->getBody() . '</p>');

        $this->symfonyMailer->send($email);

        // lui envoyer un email l'informant qu'il y a une nouvelle réponse de disponible
    }
}