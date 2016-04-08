<?php

namespace Teller\Command;

use Teller\Event\BakskeWasClaimed;
use Teller\Event\EventStream;
use Teller\Notifier;
use Teller\BakskeId;
use DateTime;

final class ClaimBakskeHandler
{
    private $eventstream;
    private $notifier;

    public function __construct(EventStream $eventstream, Notifier $notifier)
    {
        $this->eventstream = $eventstream;
        $this->notifier = $notifier;
    }

    public function handle(ClaimBakske $command)
    {
        $event = new BakskeWasClaimed(
            $command->bakske,
            $command->by,
            $command->from,
            $command->howmany,
            new DateTime('now')
        );

        $this->eventstream->append($event);

        $this->notifier->askToAdmitDefeat($event);
    }
}
