<?php 

namespace App\Helper;

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
    public function sendNewAnswerAvailableMail() :void
    {

        $email = (new Email())
            ->from('roman.ab@numericable.fr')
            ->to('kurtzftw@gmail.com')
            
            ->cc('osef')
            ->bcc($this->fromEmail)
            ->subject('yo')
            ->html('salut ça marche ?');

        $this->symfonyMailer->send($email);

        // lui envoyer un email l'informant qu'il y a une nouvelle réponse de disponible
    }
}