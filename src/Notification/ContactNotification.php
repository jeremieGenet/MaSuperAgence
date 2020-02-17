<?php

namespace App\Notification;

use Twig\Environment;
use App\Entity\Contact;

// Envoi un email à l'utilisateur qui soummet le formulaire de contact
class ContactNotification{

    private $mailer;
    private $renderer;

    // Utilisation de Swift Mailer pour l'envoie d'email, et de Environment qui permet d'utiliser le moteur de rendu TWIG
    public function __construct(\Swift_Mailer $mailer, Environment $renderer){
        $this->mailer = $mailer;
        $this->renderer = $renderer;
    }

    public function notify(Contact $contact){
        // Config du mail (méthodes issues de Swift_Mailer)
        $message = (new \Swift_Message('Agence : ' . $contact->getProperty()->getTitle()))
            ->setFrom('essai@agence.fr') // adresse de l'expéditeur du mail
            ->setTo('contact@agence.fr') // adresse de l'expéditeur du mail
            ->setReplyTo($contact->getEmail()) // adresse ou envoyer le mail
            ->setBody($this->renderer->render('emails/contact.html.twig', [
                'contact' => $contact // contenu du mail (fichier twig)
            ]), 'text/html') // option qui donne le type de contenu du mail
        ;
        // Envoie du mail
        $this->mailer->send($message);
    }

}