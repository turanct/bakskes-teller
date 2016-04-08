<?php

namespace Teller\Command;

use Teller\Event\BakskeWasReceived;
use Teller\BakskeId;
use Teller\UserId;
use DateTime;

date_default_timezone_set('Europe/Brussels');

class ReceiveBakskeHandlerTest extends \PHPUnit_Framework_TestCase
{
    public function test_it_puts_an_event_on_the_stream()
    {
        $bakskeId = BakskeId::generate();

        $expectedEvent = new BakskeWasReceived(
            $bakskeId,
            new UserId('toon'),
            new DateTime('now')
        );

        $stream = $this->getMockBuilder('\\Teller\\Event\\EventStream')->getMock();
        $stream
            ->expects($this->once())
            ->method('append')
            ->with($this->equalTo($expectedEvent))
        ;

        $command = new ReceiveBakske(
            $bakskeId,
            new UserId('toon')
        );

        $handler = new ReceiveBakskeHandler($stream);
        $handler->handle($command);
    }
}
