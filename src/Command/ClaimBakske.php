<?php

namespace Teller\Command;

use Teller\BakskeId;
use Teller\UserId;
use InvalidArgumentException;

final class ClaimBakske
{
    public $bakske;
    public $by;
    public $from;
    public $howmany;

    /**
     * Claim a bakske
     *
     * @param BakskeId $bakske  The identifier for this bakske
     * @param UserId[] $by      A list of user identifiers
     * @param UserId[] $from    A list of user identifiers
     * @param int      $howmany How many bakskes were claimed?
     */
    public function __construct(BakskeId $bakske, array $by, array $from, $howmany = 1)
    {
        foreach (array_merge($by, $from) as $userId) {
            if (!$userId instanceOf UserId) {
                throw new InvalidArgumentException('Not a valid userId: "' . $userId . '"');
            }
        }

        $this->bakske = $bakske;
        $this->by = $by;
        $this->from = $from;
        $this->howmany = (int) $howmany;
    }
}
