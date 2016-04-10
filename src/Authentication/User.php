<?php

namespace Teller\Authentication;

use Teller\UserId;

final class User
{
    private $id;
    private $name;
    private $email;

    public function __construct(UserId $id, Name $name, Email $email)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
    }

    public function getId()
    {
        return $this->id;
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
