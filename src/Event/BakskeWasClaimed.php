<?php

namespace Teller\Event;

final class BakskeWasClaimed
{
    private $bakske;
    private $by;
    private $from;
    private $when;
    private $howmany;

    /**
     * A bakske was claimed
     *
     * @param BakskeId $bakske  The identifier for this bakske
     * @param UserId[] $by      A list of user identifiers
     * @param UserId[] $from    A list of user identifiers
     * @param DateTime $when    When?
     * @param int      $howmany How many bakskes were claimed?
     */
    public function __construct(
        BakskeId $bakske,
        array $by,
        array $from,
        DateTime $when,
        $howmany = 1
    ) {
        $this->bakske = $bakske;
        $this->by = $by;
        $this->from = $from;
        $this->when = $when;
        $this->howmany = (int) $howmany;
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

    public function getWhen()
    {
        return $this->when;
    }

    public function getHowMany()
    {
        return $this->howmany;
    }
}
