<?php

namespace Teller\Command;

use Teller\BakskeId;
use Teller\UserId;

final class AdmitDefeat
{
    public $bakske;
    public $userId;

    /**
     * Claim a bakske
     *
     * @param BakskeId $bakske The identifier for this bakske
     * @param UserId   $userId The user that's admitting defeat
     */
    public function __construct(BakskeId $bakske, UserId $userId)
    {
        $this->bakske = $bakske;
        $this->userId = $userId;
    }
}
