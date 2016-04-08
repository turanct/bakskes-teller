<?php

namespace Teller\Event;

use Teller\BakskeId;
use Teller\UserId;
use DateTime;

final class BakskeWasReceived implements Event
{
    private $bakske;
    private $userId;
    private $when;

    /**
     * A loser admitted defeat
     *
     * @param BakskeId $bakske The identifier for this bakske
     * @param UserId   $userId Received by whom?
     * @param DateTime $when   When?
     */
    public function __construct(BakskeId $bakske, UserId $userId, DateTime $when)
    {
        $this->bakske = $bakske;
        $this->userId = $userId;
        $this->when = $when;
    }

    public function getBakske()
    {
        return $this->bakske;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getWhen()
    {
        return $this->when;
    }
}
