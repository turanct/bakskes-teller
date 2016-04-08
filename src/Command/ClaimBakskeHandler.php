<?php

namespace Teller\Command;

use Teller\Bakske;
use Teller\BakskesRepository;

final class ClaimBakskeHandler
{
    private $repository;

    public function __construct(BakskesRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(ClaimBakske $command)
    {
        $bakske = Bakske::claim(
            $command->winners,
            $command->losers,
            $command->howmany,
        );

        $this->repository->persist($bakske);
    }
}
