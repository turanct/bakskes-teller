<?php

namespace Teller\Authentication;

interface UserRepository
{
    public function persist(User $user);
}
