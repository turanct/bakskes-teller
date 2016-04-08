<?php

namespace Teller;

final class BakskeId
{
    private $id;

    public function __construct($id)
    {
        $this->id = (string) $id;
    }

    public static function generate()
    {
        $id = uniqid('bakskeId_', true);

        return new static($id);
    }

    public function __toString()
    {
        return $this->id;
    }
}
