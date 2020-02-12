<?php

namespace App\Notification;

use Twig\Environment;
use App\Entity\Contact;


class ContactNotification{

    private $mailer;
    private $renderer;

    // Utilisation de Swift Mailer pour l'envoie d'email, et de Environment qui permet d'utiliser le moteur de rendu TWIG
    public function __construct(\Swift_Mailer $mailer, Environment $renderer){
        $this->mailer = $mailer;
        $this->renderer = $renderer;
    }

    public function notify(Contact $contact){
        $message = (new \Swift_Message('Agence : ' . $contact->getProperty()->getTitle()))
            ->setFrom('essai@agence.fr')
            ->setTo('contact@agence.fr')
            ->setReplyTo($contact->getEmail())
            ->setBody($this->renderer->render('emails/contact.html.twig', [
                'contact' => $contact
            ]), 'text/html')
        ;

        $this->mailer->send($message);
    }

}