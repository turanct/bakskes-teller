<?php

namespace Teller\Command;

use Teller\Event\LoserAdmittedDefeat;
use Teller\BakskeId;
use Teller\UserId;
use DateTime;

date_default_timezone_set('Europe/Brussels');

class AdmitDefeatHandlerTest extends \PHPUnit_Framework_TestCase
{
    public function test_it_puts_an_event_on_the_stream()
    {
        $bakskeId = BakskeId::generate();

        $expectedEvent = new LoserAdmittedDefeat(
            $bakskeId,
            new UserId('joachim'),
            new DateTime('now')
        );

        $stream = $this->getMockBuilder('\\Teller\\Event\\EventStream')->getMock();
        $stream
            ->expects($this->once())
            ->method('append')
            ->with($this->equalTo($expectedEvent))
        ;

        $command = new AdmitDefeat(
            $bakskeId,
            new UserId('joachim')
        );

        $handler = new AdmitDefeatHandler($stream);
        $handler->handle($command);
    }
}
