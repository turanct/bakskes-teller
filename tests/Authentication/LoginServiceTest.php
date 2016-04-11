<?php

namespace Teller\Authentication;

use Teller\UserId;

class LoginServiceTest extends \PHPUnit_Framework_TestCase
{
    public function test_it_gives_out_tokens_by_email()
    {
        $email = 'toon@example.com';
        $user = new User(
            UserId::generate(),
            new Name('toon'),
            new Email('toon@example.com')
        );
        $checkToken = function($token) { return $token instanceof LoginToken; };

        $userRepository = $this->getMock('\\Teller\\Authentication\\UserRepository');
        $userRepository
            ->expects($this->once())
            ->method('getByEmail')
            ->with($this->equalTo(new Email($email)))
            ->willReturn($user)
        ;

        $tokenRepository = $this->getMock('\\Teller\\Authentication\\LoginTokenRepository');
        $tokenRepository
            ->expects($this->once())
            ->method('persist')
            ->with($this->callback($checkToken))
        ;

        $notifier = $this->getMock('\\Teller\\Authentication\\LoginNotifier');
        $notifier
            ->expects($this->once())
            ->method('sendLoginToken')
            ->with($this->callback($checkToken))
        ;

        $service = new LoginService(
            $userRepository,
            $tokenRepository,
            $notifier
        );

        $service->requestToken($email);
    }

    public function test_it_activates_a_token()
    {
        $tokenString = 'test token';
        $userId = UserId::generate();
        $inactiveToken = new LoginToken(
            $tokenString,
            $userId,
            new Email('toon@example.com'),
            false
        );
        $activeToken = new LoginToken(
            $tokenString,
            $userId,
            new Email('toon@example.com'),
            true
        );

        $userRepository = $this->getMock('\\Teller\\Authentication\\UserRepository');
        $notifier = $this->getMock('\\Teller\\Authentication\\LoginNotifier');

        $tokenRepository = $this->getMock('\\Teller\\Authentication\\LoginTokenRepository');
        $tokenRepository
            ->expects($this->once())
            ->method('get')
            ->with($this->equalTo($tokenString))
            ->willReturn($inactiveToken)
        ;
        $tokenRepository
            ->expects($this->once())
            ->method('persist')
            ->with($this->equalTo($activeToken))
        ;

        $service = new LoginService(
            $userRepository,
            $tokenRepository,
            $notifier
        );

        $service->activateToken($tokenString);
    }

    public function test_it_converts_an_active_token_to_a_user()
    {
        $userId = UserId::generate();
        $email = new Email('toon@example.com');
        $user = new User(
            $userId,
            new Name('toon'),
            $email
        );

        $tokenString = 'test token';
        $activeToken = new LoginToken(
            $tokenString,
            $userId,
            $email,
            true
        );

        $notifier = $this->getMock('\\Teller\\Authentication\\LoginNotifier');

        $tokenRepository = $this->getMock('\\Teller\\Authentication\\LoginTokenRepository');
        $tokenRepository
            ->expects($this->once())
            ->method('get')
            ->with($this->equalTo($tokenString))
            ->willReturn($activeToken)
        ;

        $userRepository = $this->getMock('\\Teller\\Authentication\\UserRepository');
        $userRepository
            ->expects($this->once())
            ->method('getById')
            ->with($this->equalTo($userId))
            ->willReturn($user)
        ;

        $service = new LoginService(
            $userRepository,
            $tokenRepository,
            $notifier
        );

        $userFromToken = $service->tokenToUser($tokenString);

        $this->assertEquals($user, $userFromToken);
    }

    /**
     * @expectedException Teller\Authentication\Exception\ActivateTokenFirst
     */
    public function test_it_throws_when_asking_user_for_inactive_token()
    {
        $tokenString = 'test token';
        $inactiveToken = new LoginToken(
            $tokenString,
            UserId::generate(),
            new Email('toon@example.com'),
            false
        );

        $notifier = $this->getMock('\\Teller\\Authentication\\LoginNotifier');
        $userRepository = $this->getMock('\\Teller\\Authentication\\UserRepository');

        $tokenRepository = $this->getMock('\\Teller\\Authentication\\LoginTokenRepository');
        $tokenRepository
            ->expects($this->once())
            ->method('get')
            ->with($this->equalTo($tokenString))
            ->willReturn($inactiveToken)
        ;

        $service = new LoginService(
            $userRepository,
            $tokenRepository,
            $notifier
        );

        $userFromToken = $service->tokenToUser($tokenString);
    }
}
