<?php

namespace Teller\Event;

use Teller\BakskeId;

interface EventStream
{
    /**
     * Append an event to the stream
     *
     * @param Event $event
     */
    public function append(Event $event);

    /**
     * Get the events for a certain Aggregate
     *
     * @param BakskeId $aggregateId
     */
    public function getEventsForAggregate(BakskeId $aggregateId);
}
