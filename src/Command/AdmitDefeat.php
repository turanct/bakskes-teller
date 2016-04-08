<?php

namespace Teller\Command;

use Teller\BakskeId;
use Teller\UserId;

final class AdmitDefeat
{
    public $bakske;
    public $loserId;

    /**
     * Claim a bakske
     *
     * @param BakskeId $bakske  The identifier for this bakske
     * @param UserId   $loserId The user that's admitting defeat
     */
    public function __construct(BakskeId $bakske, UserId $loserId)
    {
        $this->bakske = $bakske;
        $this->loserId = $loserId;
    }
}
