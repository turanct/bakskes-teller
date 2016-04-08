<?php

namespace Teller\Command;

use Teller\Event\LoserAdmittedDefeat;
use Teller\Event\EventStream;
use Teller\BakskeId;
use DateTime;

final class AdmitDefeatHandler
{
    private $eventstream;

    public function __construct(EventStream $eventstream)
    {
        $this->eventstream = $eventstream;
    }

    public function handle(AdmitDefeat $command)
    {
        $event = new LoserAdmittedDefeat(
            $command->bakske,
            $command->userId,
            new DateTime('now')
        );

        $this->eventstream->append($event);
    }
}
