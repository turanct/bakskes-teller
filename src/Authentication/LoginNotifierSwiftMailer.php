<?php

namespace Teller\Authentication;

use Swift_Mailer;
use Swift_Message;

final class LoginNotifierSwiftMailer implements LoginNotifier
{
    private $mailer;

    public function __construct(Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendLoginToken(LoginToken $token, User $user)
    {
        $loginUrl = 'http://bakske.dev/login/' . $token->getSecret();

        $body = 'Hallo ' . $user->getName();
        $body .= "\n\n" . 'Log in door op deze link te klikken:';
        $body .= "\n" . $loginUrl;

        $message = Swift_Message::newInstance('Bakske Verneuzeld Registratie')
            ->setFrom(array('no-reply@bakske-verneuzeld.be' => 'Bakske Verneuzeld'))
            ->setTo(array((string) $user->getEmail() => (string) $user->getName()))
            ->setBody($body);

        $this->mailer->send($message);
    }
}
