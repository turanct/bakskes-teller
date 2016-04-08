<?php

namespace Teller\Event;

use Teller\BakskeId;
use DateTime;

final class BakskeWasClaimed implements Event
{
    private $bakske;
    private $by;
    private $from;
    private $howmany;
    private $when;

    /**
     * A bakske was claimed
     *
     * @param BakskeId $bakske  The identifier for this bakske
     * @param UserId[] $by      A list of user identifiers
     * @param UserId[] $from    A list of user identifiers
     * @param int      $howmany How many bakskes were claimed?
     * @param DateTime $when    When?
     */
    public function __construct(
        BakskeId $bakske,
        array $by,
        array $from,
        $howmany,
        DateTime $when
    ) {
        $this->bakske = $bakske;
        $this->by = $by;
        $this->from = $from;
        $this->howmany = (int) $howmany;
        $this->when = $when;
    }

    public function getBakske()
    {
        return $this->bakske;
    }

    public function getBy()
    {
        return $this->by;
    }

    public function getFrom()
    {
        return $this->from;
    }

    public function getHowMany()
    {
        return $this->howmany;
    }

    public function getWhen()
    {
        return $this->when;
    }
}
