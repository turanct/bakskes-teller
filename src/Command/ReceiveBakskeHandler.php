<?php

namespace Teller\Command;

use Teller\BakskesRepository;

final class ReceiveBakskeHandler
{
    private $repository;

    public function __construct(BakskesRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(ReceiveBakske $command)
    {
        $bakske = $this->repository->getById($command->bakske);

        $bakske->receive($command->winner);

        $this->repository->persist($bakske);
    }
}
