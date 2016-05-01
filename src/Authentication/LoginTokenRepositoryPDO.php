<?php

namespace Teller\Authentication;

use PDO;
use ReflectionProperty;
use Teller\UserId;

final class LoginTokenRepositoryPDO implements LoginTokenRepository
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function persist(LoginToken $token)
    {
        $query = 'INSERT INTO `login_tokens` (`token`, `secret`, `user_id`, `email`, `status`)
                  VALUES (:token, :secret, :userId, :email, :status)
                  ON DUPLICATE KEY UPDATE `status`=:status';

        $statement = $this->pdo->prepare($query);

        // Get private value from the token
        $property = new ReflectionProperty('Teller\\Authentication\\LoginToken', 'token');
        $property->setAccessible(true);
        $statement->bindParam(':token', $property->getValue($token));

        $property = new ReflectionProperty('Teller\\Authentication\\LoginToken', 'secret');
        $property->setAccessible(true);
        $statement->bindParam(':secret', $property->getValue($token));

        $statement->bindParam(':email', $token->getEmail());
        $statement->bindParam(':userId', $token->getUserId());

        $status = $token->isActive() ? 'active' : 'inactive';
        $statement->bindParam(':status', $status);

        $statement->execute();
    }

    public function get($tokenString)
    {
        $query = 'SELECT *
                  FROM `login_tokens`
                  WHERE `token` = :token
                  LIMIT 1';

        $statement = $this->pdo->prepare($query);
        $statement->bindParam(':token', (string) $tokenString);

        $statement->execute();

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return new LoginToken(
            $result['token'],
            $result['secret'],
            new UserId($result['user_id']),
            new Email($result['email']),
            $result['status'] === 'active'
        );
    }

    public function getBySecret($secret)
    {
        $secret = (string) $secret;

        $query = 'SELECT *
                  FROM `login_tokens`
                  WHERE `secret` = :secret
                  LIMIT 1';

        $statement = $this->pdo->prepare($query);
        $statement->bindParam(':secret', $secret);

        $statement->execute();

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return new LoginToken(
            $result['token'],
            $result['secret'],
            new UserId($result['user_id']),
            new Email($result['email']),
            $result['status'] === 'active'
        );
    }
}
