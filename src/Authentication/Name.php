<?php

namespace Teller\Authentication;

final class Name
{
    private $name;

    public function __construct($name)
    {
        $this->name = (string) $name;
    }

    public function __toString()
    {
        return $this->name;
    }
}
