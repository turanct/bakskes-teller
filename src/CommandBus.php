<?php

namespace Teller;

use Teller\Exception\HandlerNotFound;

final class CommandBus
{
    private $map = array();

    public function register($commandType, $handler)
    {
        $this->map[$commandType] = $handler;
    }

    public function handle($command)
    {
        $commandType = get_class($command);

        if (!isset($this->map[$commandType])) {
            throw new HandlerNotFound($commandType);
        }

        $this->map[$commandType]->handle($command);
    }
}
