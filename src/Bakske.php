<?php

namespace Teller;

use Teller\Event\BakskeWasClaimed;
use Teller\Event\LoserAdmittedDefeat;
use Teller\Event\BakskeWasReceived;
use DateTime;

final class Bakske
{
    private $id;
    private $events;

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

        return new static($id, $events);
    }

    public function admitDefeat(UserId $loser)
    {
        $this->events[] = new LoserAdmittedDefeat(
            $this->id,
            $loser,
            new DateTime('now')
        );
    }

    public function receive(UserId $winner)
    {
        $this->events[] = new BakskeWasReceived(
            $this->id,
            $winner,
            new DateTime('now')
        );
    }

    public function getId()
    {
        return $this->id;
    }

    public function getRecordedEvents()
    {
        return $this->events;
    }
}
