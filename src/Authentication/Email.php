<?php

namespace Teller\Authentication;

final class Email
{
    private $email;

    public function __construct($email)
    {
        $this->email = (string) $email;
    }

    public function __toString()
    {
        return $this->email;
    }
}
