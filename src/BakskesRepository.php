<?php

namespace Teller;

use Teller\Event\EventStream;

final class BakskesRepository
{
    private $eventstream;

    public function __construct(EventStream $eventstream)
    {
        $this->eventstream = $eventstream;
    }

    public function getById(BakskeId $id)
    {
        $events = $this->eventstream->getEventsForAggregate($id);

        return new Bakske($id, $events);
    }

    public function persist(Bakske $bakske)
    {
        foreach ($bakske->getRecordedEvents() as $event) {
            $this->eventstream->append($event);
        }
    }
}
