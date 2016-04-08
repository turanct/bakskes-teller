<?php

namespace Teller\Command;

use Teller\Event\BakskeWasClaimed;
use Teller\BakskeId;
use Teller\UserId;
use DateTime;

date_default_timezone_set('Europe/Brussels');

class ClaimBakskeHandlerTest extends \PHPUnit_Framework_TestCase
{
    public function test_it_puts_an_event_on_the_stream()
    {
        $bakskeId = BakskeId::generate();

        $expectedEvent = new BakskeWasClaimed(
            $bakskeId,
            array(new UserId('toon')),
            array(new UserId('joachim')),
            1,
            new DateTime('now')
        );

        $stream = $this->getMockBuilder('\\Teller\\Event\\EventStream')->getMock();
        $stream
            ->expects($this->once())
            ->method('append')
            ->with($this->equalTo($expectedEvent))
        ;

        $notifier = $this->getMockBuilder('\\Teller\\Notifier')->getMock();
        $notifier
            ->expects($this->once())
            ->method('askToAdmitDefeat')
            ->with($this->equalTo($expectedEvent))
        ;

        $command = new ClaimBakske(
            $bakskeId,
            array(new UserId('toon')),
            array(new UserId('joachim')),
            1
        );

        $handler = new ClaimBakskeHandler($stream, $notifier);
        $handler->handle($command);
    }
}
