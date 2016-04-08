<?php

namespace Teller\Command;

use Teller\BakskesRepository;

final class AdmitDefeatHandler
{
    private $repository;

    public function __construct(BakskesRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(AdmitDefeat $command)
    {
        $bakske = $this->repository->getById($command->bakske);

        $bakske->admitDefeat($command->userId);

        $this->repository->persist($bakske);
    }
}
