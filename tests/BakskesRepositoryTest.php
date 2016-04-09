<?php

namespace Teller;

use Teller\Event\BakskeWasClaimed;
use Teller\Event\LoserAdmittedDefeat;
use Teller\Event\WinnerReceivedBakske;
use DateTime;

date_default_timezone_set('Europe/Brussels');

class BakskesRepositoryTest extends \PHPUnit_Framework_TestCase
{
    public function test_it_gets_a_bakske_by_id()
    {
        $id = new BakskeId('foo');

        $stream = $this->getMockBuilder('\\Teller\\EventStream')->getMock();
        $stream
            ->expects($this->once())
            ->method('getEventsForAggregate')
            ->with($this->equalTo($id))
            ->willReturn(array())
        ;

        $repository = new BakskesRepository($stream);

        $bakske = $repository->getById($id);
        $expectedBakske = new Bakske($id, array());

        $this->assertEquals($expectedBakske, $bakske);
    }

    public function test_it_persists_an_aggregates_events()
    {
        $id = new BakskeId('foo');
        $winner = new UserId('Toon');
        $loser = new UserId('Joachim');
        $claimEvent = new BakskeWasClaimed(
            $id,
            array($winner),
            array($loser),
            1,
            new DateTime('now')
        );
        $event1 = new LoserAdmittedDefeat(
            $id,
            $loser,
            new DateTime('now')
        );
        $event2 = new WinnerReceivedBakske(
            $id,
            $winner,
            new DateTime('now')
        );

        $stream = $this->getMockBuilder('\\Teller\\EventStream')->getMock();
        $stream
            ->expects($this->exactly(2))
            ->method('append')
            ->withConsecutive(
                array($event1),
                array($event2)
            )
        ;

        $repository = new BakskesRepository($stream);

        $bakske = new Bakske($id, array($claimEvent));

        $bakske->admitDefeat($loser);
        $bakske->receive($winner);

        $repository->persist($bakske);
    }
}
