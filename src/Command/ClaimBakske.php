<?php

namespace Teller\Command;

use Teller\BakskeId;
use Teller\UserId;
use InvalidArgumentException;

final class ClaimBakske
{
    public $bakske;
    public $winners;
    public $losers;
    public $howmany;

    /**
     * Claim a bakske
     *
     * @param BakskeId $bakske  The identifier for this bakske
     * @param UserId[] $winners A list of user identifiers
     * @param UserId[] $losers  A list of user identifiers
     * @param int      $howmany How many bakskes were claimed?
     */
    public function __construct(BakskeId $bakske, array $winners, array $losers, $howmany = 1)
    {
        foreach (array_merge($winners, $losers) as $userId) {
            if (!$userId instanceOf UserId) {
                throw new InvalidArgumentException('Not a valid userId: "' . $userId . '"');
            }
        }

        $this->bakske = $bakske;
        $this->winners = $winners;
        $this->losers = $losers;
        $this->howmany = (int) $howmany;
    }
}
