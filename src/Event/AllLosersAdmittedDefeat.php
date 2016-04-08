<?php

namespace Teller\Event;

final class AllLosersAdmittedDefeat implements Event
{
    private $bakske;
    private $when;

    /**
     * A loser admitted defeat
     *
     * @param BakskeId $bakske The identifier for this bakske
     * @param DateTime $when   When?
     */
    public function __construct(BakskeId $bakske, DateTime $when)
    {
        $this->bakske = $bakske;
        $this->when = $when;
    }

    public function getBakske()
    {
        return $this->bakske;
    }

    public function getWhen()
    {
        return $this->when;
    }
}
