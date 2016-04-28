<?php

namespace Teller\Authentication;

use Swift_Mailer;
use Swift_Message;

final class RegistrationNotifierSwiftMailer implements RegistrationNotifier
{
    private $mailer;

    public function __construct(Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function notify(Registration $registration, Secret $secret)
    {
        $confirmUrl = 'http://bakske.dev/register/confirm/' . $registration->getEmail();
        $confirmUrl .= '/' . $secret;

        $body = 'Hallo ' . $registration->getName();
        $body .= "\n\n" . 'Bevestig je registratie door op deze link te klikken:';
        $body .= "\n" . $confirmUrl;

        $message = Swift_Message::newInstance('Bakske Verneuzeld Registratie')
            ->setFrom(array('no-reply@bakske-verneuzeld.be' => 'Bakske Verneuzeld'))
            ->setTo(array((string) $registration->getEmail() => (string) $registration->getName()))
            ->setBody($body);

        $this->mailer->send($message);
    }
}
