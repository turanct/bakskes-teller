<?php

namespace Teller\Authentication;

final class Secret
{
    private $secret;

    public function __construct($secret)
    {
        $this->secret = (string) $secret;
    }

    public static function generate()
    {
        $secret = md5(uniqid('Secret_', true));

        return new static($secret);
    }

    public function __toString()
    {
        return $this->secret;
    }
}
