<?php

namespace Teller\Authentication;

use Teller\UserId;

interface UserRepository
{
    public function persist(User $user);
    public function getById(UserId $id);
    public function getByEmail(Email $email);
}
