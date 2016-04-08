<?php

namespace Teller;

use Teller\Event\BakskeWasClaimed;
use Teller\Event\LoserAdmittedDefeat;
use Teller\Event\BakskeWasReceived;
use DateTime;

date_default_timezone_set('Europe/Brussels');

class BakskeTest extends \PHPUnit_Framework_TestCase
{
    public function test_it_records_events_when_being_claimed()
    {
        $winners = array(new UserId('toon'));
        $losers = array(new UserId('joachim'));
        $numberOfBakskes = 1;

        $now = new DateTime('now');
        $bakske = Bakske::claim($winners, $losers, $numberOfBakskes);

        $this->assertEquals(
            array(
                new BakskeWasClaimed($bakske->getId(), $winners, $losers, $numberOfBakskes, $now),
            ),
            $bakske->getRecordedEvents()
        );
    }

    public function test_it_allows_its_losers_to_admit_defeat()
    {
        $id = new BakskeId('test');
        $loser = new UserId('joachim');
        $now = new DateTime('now');

        $existingEvents = array(
            new BakskeWasClaimed(
                $id,
                array(new UserId('toon')),
                array($loser),
                1,
                $now
            ),
        );

        $bakske = new Bakske($id, $existingEvents);

        $bakske->admitDefeat($loser);

        $expectedEvents = array();
        $expectedEvents[] = new LoserAdmittedDefeat($id, $loser, $now);

        $this->assertEquals($expectedEvents, $bakske->getRecordedEvents());
    }

    public function test_it_allows_its_winners_to_receive_a_bakske()
    {
        $id = new BakskeId('test');
        $winner = new UserId('toon');
        $loser = new UserId('joachim');
        $now = new DateTime('now');

        $existingEvents = array(
            new BakskeWasClaimed(
                $id,
                array($winner),
                array($loser),
                1,
                $now
            ),
            new LoserAdmittedDefeat($id, $loser, $now),
        );

        $bakske = new Bakske($id, $existingEvents);

        $bakske->receive($winner);

        $expectedEvents = array();
        $expectedEvents[] = new BakskeWasReceived($id, $winner, $now);

        $this->assertEquals($expectedEvents, $bakske->getRecordedEvents());
    }
}
