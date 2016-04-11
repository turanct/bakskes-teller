<?php

namespace Teller\Authentication;

interface LoginTokenRepository
{
    public function persist(LoginToken $token);
    public function get($token);
}
