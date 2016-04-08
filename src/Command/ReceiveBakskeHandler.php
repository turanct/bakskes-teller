<?php

namespace Teller\Command;

use Teller\Event\BakskeWasReceived;
use Teller\Event\EventStream;
use Teller\BakskeId;
use DateTime;

final class ReceiveBakskeHandler
{
    private $eventstream;

    public function __construct(EventStream $eventstream)
    {
        $this->eventstream = $eventstream;
    }

    public function handle(ReceiveBakske $command)
    {
        $event = new BakskeWasReceived(
            $command->bakske,
            $command->userId,
            new DateTime('now')
        );

        $this->eventstream->append($event);
    }
}
