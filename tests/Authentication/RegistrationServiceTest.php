<?php

namespace Teller\Authentication;

class RegistrationServiceTest extends \PHPUnit_Framework_TestCase
{
    public function test_it_asks_confirmation_and_waits()
    {
        $name = 'toon';
        $email = 'toon@example.com';

        $checkRegistration = function(Registration $registration) use ($name, $email) {
            if (
                $registration->getName() == new Name($name)
                && $registration->getEmail() == new Email($email)
            ) {
                return true;
            }

            return false;
        };

        $repository = $this->getMockBuilder('\\Teller\\Authentication\\RegistrationRepository')->getMock();
        $repository
            ->expects($this->once())
            ->method('persist')
            ->with($this->callback($checkRegistration))
        ;

        $notifier = $this->getMockBuilder('\\Teller\\Authentication\\RegistrationNotifier')->getMock();
        $notifier
            ->expects($this->once())
            ->method('notify')
            ->with($this->callback($checkRegistration))
        ;

        $userRepository = $this->getMockBuilder('\\Teller\\Authentication\\UserRepository')->getMock();

        $service = new RegistrationService($repository, $notifier, $userRepository);

        $service->register($name, $email);
    }

    public function test_it_creates_a_user_when_registration_confirmed()
    {
        $email = 'toon@example.com';
        $name = new Name('toon');
        $emailInstance = new Email($email);
        $secret = Secret::generate();
        $registration = new Registration($name, $emailInstance, $secret);

        $repository = $this->getMockBuilder('\\Teller\\Authentication\\RegistrationRepository')->getMock();
        $repository
            ->expects($this->once())
            ->method('getByEmail')
            ->with($this->equalTo($email))
            ->willReturn($registration)
        ;

        $notifier = $this->getMockBuilder('\\Teller\\Authentication\\RegistrationNotifier')->getMock();

        $checkUser = function(User $user) use ($name, $email) {
            if (
                $user->getName() == new Name($name)
                && $user->getEmail() == new Email($email)
            ) {
                return true;
            }

            return false;
        };
        $userRepository = $this->getMockBuilder('\\Teller\\Authentication\\UserRepository')->getMock();
        $userRepository
            ->expects($this->once())
            ->method('persist')
            ->with($this->callback($checkUser))
        ;

        $service = new RegistrationService($repository, $notifier, $userRepository);

        $service->confirm($email, $secret);
    }
}
