<?php

namespace Teller\Authentication;

use Teller\UserId;
use PDO;

final class UserRepositoryPDO implements UserRepository
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function persist(User $user)
    {
        $query = 'INSERT INTO `users` (`id`, `name`, `email`)
                  VALUES (:id, :name, :email)';

        $statement = $this->pdo->prepare($query);

        $statement->bindParam(':id', $user->getId());
        $statement->bindParam(':name', $user->getName());
        $statement->bindParam(':email', $user->getEmail());

        $statement->execute();
    }

    public function getById(UserId $id)
    {
        $query = 'SELECT *
                  FROM `users`
                  WHERE `id` = :id
                  LIMIT 1';

        $statement = $this->pdo->prepare($query);
        $statement->bindParam(':id', $id);

        $statement->execute();

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return new User(
            new UserId($result['id']),
            new Name($result['name']),
            new Email($result['email'])
        );
    }

    public function getByEmail(Email $email)
    {
        $query = 'SELECT *
                  FROM `users`
                  WHERE `email` = :email
                  LIMIT 1';

        $statement = $this->pdo->prepare($query);
        $statement->bindParam(':email', $email);

        $statement->execute();

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return new User(
            new UserId($result['id']),
            new Name($result['name']),
            new Email($result['email'])
        );
    }
}
