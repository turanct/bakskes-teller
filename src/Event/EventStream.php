<?php

namespace Teller\Event;

interface EventStream
{
    /**
     * Append an event to the stream
     *
     * @param Event $event
     */
    public function append(Event $event);
}
