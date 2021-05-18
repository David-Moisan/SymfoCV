<?php

namespace App\Notification;

use App\Entity\Contact;
use Swift_Mailer;
use Twig\Environment;

class ContactNotification
{
    public function __construct(Swift_Mailer $mailer, Environment $renderer)
    {
        $this->mailer = $mailer;
        $this->renderer = $renderer;
    }

    public function notify(Contact $contact)
    {
        $email = (new \Swift_Message('Tentative de contact :'.$contact->getSociete()))
            ->setFrom($contact->getEmail())
            ->setTo('adresse mail')
            ->setBody($this->renderer->render('contact/index.html.twig', [
                'contact' => $contact,
            ]), 'text/html');
        $this->mailer->send($email);
    }
}
