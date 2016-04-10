<?php

namespace Teller\Authentication;

use Teller\UserId;
use Teller\Authentication\Exception\CanNotConfirmWithoutSecret;

final class Registration
{
    private $name;
    private $email;
    private $secret;

    public function __construct(Name $name, Email $email, Secret $secret)
    {
        $this->name = $name;
        $this->email = $email;
        $this->secret = $secret;
    }

    public function confirm(Secret $secret)
    {
        if ($secret != $this->secret) {
            throw new CanNotConfirmWithoutSecret();
        }

        return new User(
            UserId::generate(),
            $this->name,
            $this->email
        );
    }

    public function getName()
    {
        return $this->name;
    }

    public function getEmail()
    {
        return $this->email;
    }
}
