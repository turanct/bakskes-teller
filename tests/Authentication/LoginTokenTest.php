<?php

namespace Teller\Authentication;

use Teller\UserId;

class LoginTokenTest extends \PHPUnit_Framework_TestCase
{
    public function test_it_generates_tokens_for_users()
    {
        $userId = UserId::generate();
        $user = new User(
            $userId,
            new Name('toon'),
            new Email('toon@example.com')
        );

        $expectedToken = new LoginToken(
            'test123',
            'secret123',
            $userId,
            new Email('toon@example.com'),
            false
        );

        $actualToken = LoginToken::generateFor($user);

        $this->assertEquals($expectedToken->isActive(), $actualToken->isActive());
        $this->assertEquals($expectedToken->getUserId(), $actualToken->getUserId());
        $this->assertEquals($expectedToken->getEmail(), $actualToken->getEmail());
    }

    public function test_inactive_tokens_can_be_activated()
    {
        $inactiveToken = new LoginToken(
            'test123',
            'secret123',
            UserId::generate(),
            new Email('toon@example.com'),
            false
        );

        $this->assertFalse($inactiveToken->isActive());

        $inactiveToken->activate();

        $this->assertTrue($inactiveToken->isActive());
    }

    /**
     * @expectedException Teller\Authentication\Exception\TokenAlreadyActive
     */
    public function test_active_tokens_can_not_be_activated()
    {
        $inactiveToken = new LoginToken(
            'test123',
            'secret123',
            UserId::generate(),
            new Email('toon@example.com'),
            true
        );

        $inactiveToken->activate();
    }
}
