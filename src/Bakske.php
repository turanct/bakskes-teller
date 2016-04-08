<?php

namespace Teller;

use Teller\Event\BakskeWasClaimed;
use Teller\Event\LoserAdmittedDefeat;
use Teller\Event\BakskeWasReceived;
use Teller\Exception\OnlyLosersCanAdmitDefeat;
use Teller\Exception\CanNotAdmitDefeatTwice;
use DateTime;

final class Bakske
{
    private $id;
    private $events;
    private $recordedEvents = array();

    public function __construct(BakskeId $id, array $events)
    {
        $this->id = $id;
        $this->events = $events;
    }

    public static function claim(array $winners, array $losers, $numberOfBakskes)
    {
        $id = BakskeId::generate();

        $events = array();
        $events[] = new BakskeWasClaimed(
            $id,
            $winners,
            $losers,
            $numberOfBakskes,
            new DateTime('now')
        );

        $bakske = new static($id, $events);
        $bakske->recordedEvents = $events;

        return $bakske;
    }

    public function admitDefeat(UserId $loser)
    {
        $claimEvent = reset($this->events);

        // Only losers can admit defeat
        $losers = $claimEvent->getFrom();
        if (!in_array($loser, $losers)) {
            throw new OnlyLosersCanAdmitDefeat('"' . $loser . '" is not a loser');
        }

        // Can admit defeat only once
        foreach ($this->events as $pastEvent) {
            if (
                $pastEvent instanceof LoserAdmittedDefeat
                && $pastEvent->getLoser() == $loser
            ) {
                throw new CanNotAdmitDefeatTwice('"' . $loser . '" already admitted defeat');
            }
        }

        $event = new LoserAdmittedDefeat(
            $this->id,
            $loser,
            new DateTime('now')
        );

        $this->events[] = $event;
        $this->recordedEvents[] = $event;
    }

    public function receive(UserId $winner)
    {
        $event = new BakskeWasReceived(
            $this->id,
            $winner,
            new DateTime('now')
        );

        $this->events[] = $event;
        $this->recordedEvents[] = $event;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getRecordedEvents()
    {
        return $this->recordedEvents;
    }
}
