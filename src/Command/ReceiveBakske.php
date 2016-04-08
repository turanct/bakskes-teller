<?php

namespace Teller\Command;

use Teller\BakskeId;
use Teller\UserId;

final class ReceiveBakske
{
    public $bakske;
    public $winner;

    /**
     * Claim a bakske
     *
     * @param BakskeId $bakske The identifier for this bakske
     * @param UserId   $winner A list of user identifiers
     */
    public function __construct(BakskeId $bakske, UserId $winner)
    {
        $this->bakske = $bakske;
        $this->winner = $winner;
    }
}
