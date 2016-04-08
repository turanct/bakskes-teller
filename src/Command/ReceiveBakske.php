<?php

namespace Teller\Command;

use Teller\BakskeId;
use Teller\UserId;

final class ReceiveBakske
{
    public $bakske;
    public $userId;

    /**
     * Claim a bakske
     *
     * @param BakskeId $bakske The identifier for this bakske
     * @param UserId   $by     A list of user identifiers
     */
    public function __construct(BakskeId $bakske, UserId $userId)
    {
        $this->bakske = $bakske;
        $this->userId = $userId;
    }
}
