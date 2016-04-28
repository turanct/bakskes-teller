<?php

namespace Teller\Authentication;

use PDO;
use ReflectionProperty;

final class RegistrationRepositoryPDO implements RegistrationRepository
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function persist(Registration $registration)
    {
        $query = 'INSERT INTO `registrations` (`email`, `name`, `secret`)
                  VALUES (:email, :name, :secret)';

        $statement = $this->pdo->prepare($query);

        $statement->bindParam(':email', $registration->getEmail());
        $statement->bindParam(':name', $registration->getName());

        // Get private value Secret from the registration
        $property = new ReflectionProperty('Teller\\Authentication\\Registration', 'secret');
        $property->setAccessible(true);
        $statement->bindParam(':secret', $property->getValue($registration));

        $statement->execute();
    }

    public function remove(Registration $registration)
    {
        $query = 'DELETE FROM `registrations`
                  WHERE `email` = :email';

        $statement = $this->pdo->prepare($query);
        $statement->bindParam(':email', $registration->getEmail());

        $statement->execute();
    }

    public function getByEmail(Email $email)
    {
        $query = 'SELECT *
                  FROM `registrations`
                  WHERE `email` = :email
                  LIMIT 1';

        $statement = $this->pdo->prepare($query);
        $statement->bindParam(':email', $email);

        $statement->execute();

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return new Registration(
            new Name($result['name']),
            new Email($result['email']),
            new Secret($result['secret'])
        );
    }
}
