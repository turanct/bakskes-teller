<?php

namespace Teller\Authentication;

class RegistrationTest extends \PHPUnit_Framework_TestCase
{
    public function test_it_creates_a_user_when_confirmed()
    {
        $name = new Name('toon');
        $email = new Email('toon@example.com');
        $secret = Secret::generate();

        $registration = new Registration($name, $email, $secret);

        $newUser = $registration->confirm($secret);
        $expected = new User($newUser->getId(), $name, $email);

        $this->assertEquals($expected, $newUser);
    }

    /**
     * @expectedException Teller\Authentication\Exception\CanNotConfirmWithoutSecret
     */
    public function test_it_throws_when_confirmed_with_wrong_secret()
    {
        $name = new Name('toon');
        $email = new Email('toon@example.com');
        $secret = Secret::generate();
        $badSecret = Secret::generate();

        $registration = new Registration($name, $email, $secret);

        $newUser = $registration->confirm($badSecret);
    }
}
