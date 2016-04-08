<?php

namespace Teller\Event;

use Teller\BakskeId;
use Teller\UserId;
use DateTime;

final class LoserAdmittedDefeat implements Event
{
    private $bakske;
    private $loser;
    private $when;

    /**
     * A loser admitted defeat
     *
     * @param BakskeId $bakske The identifier for this bakske
     * @param UserId   $loser  The loser's identifier
     * @param DateTime $when   When?
     */
    public function __construct(BakskeId $bakske, UserId $loser, DateTime $when)
    {
        $this->bakske = $bakske;
        $this->loser = $loser;
        $this->when = $when;
    }

    public function getBakske()
    {
        return $this->bakske;
    }

    public function getLoser()
    {
        return $this->loser;
    }

    public function getWhen()
    {
        return $this->when;
    }
}
