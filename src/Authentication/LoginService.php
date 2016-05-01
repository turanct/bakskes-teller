<?php

namespace Teller\Authentication;

use Teller\Authentication\Exception\ActivateTokenFirst;

final class LoginService
{
    private $userRepository;
    private $tokenRepository;
    private $notifier;

    public function __construct(
        UserRepository $userRepository,
        LoginTokenRepository $tokenRepository,
        LoginNotifier $notifier
    ) {
        $this->userRepository = $userRepository;
        $this->tokenRepository = $tokenRepository;
        $this->notifier = $notifier;
    }

    public function requestToken($email)
    {
        $user = $this->userRepository->getByEmail(new Email($email));

        $token = LoginToken::generateFor($user);

        $this->tokenRepository->persist($token);
        $this->notifier->sendLoginToken($token, $user);
    }

    public function activateToken($loginSecret)
    {
        $token = $this->tokenRepository->getBySecret($loginSecret);

        $token->activate();

        $this->tokenRepository->persist($token);
    }

    public function tokenToUser($tokenString)
    {
        $token = $this->tokenRepository->get($tokenString);

        if ($token->isActive() === false) {
            throw new ActivateTokenFirst();
        }

        $user = $this->userRepository->getById($token->getUserId());

        return $user;
    }
}
