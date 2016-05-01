<?php

namespace Teller\Authentication;

use Teller\UserId;
use Teller\Authentication\Exception\TokenAlreadyActive;

final class LoginToken
{
    private $token;
    private $secret;
    private $userId;
    private $email;
    private $active;

    public function __construct($token, $secret, UserId $userId, Email $email, $active)
    {
        $this->token = (string) $token;
        $this->secret = (string) $secret;
        $this->userId = $userId;
        $this->email = $email;
        $this->active = (bool) $active;
    }

    public static function generateFor(User $user)
    {
        $token = md5(uniqid('LoginToken_', true));
        $secret = md5(uniqid('LoginSecret_', true));

        return new static($token, $secret, $user->getId(), $user->getEmail(), false);
    }

    public function activate()
    {
        if ($this->active === true) {
            throw new TokenAlreadyActive();
        }

        $this->active = true;
    }

    public function isActive()
    {
        return $this->active === true;
    }

    public function getSecret()
    {
        return $this->secret;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getEmail()
    {
        return $this->email;
    }
}
