<?php

namespace Teller\Authentication;

final class RegistrationService
{
    private $registrationRepository;
    private $notifier;
    private $userRepository;

    public function __construct(
        RegistrationRepository $registrationRepository,
        RegistrationNotifier $notifier,
        UserRepository $userRepository
    ) {
        $this->registrationRepository = $registrationRepository;
        $this->notifier = $notifier;
        $this->userRepository = $userRepository;
    }

    public function register($name, $email)
    {
        $registration = new Registration(
            new Name($name),
            new Email($email),
            Secret::generate()
        );

        $this->registrationRepository->persist($registration);
        $this->notifier->notify($registration);
    }

    public function confirm($email, $secret)
    {
        $registration = $this->registrationRepository->getByEmail(new Email($email));

        $user = $registration->confirm(new Secret($secret));

        $this->userRepository->persist($user);
    }
}
