<?php

namespace Teller\Authentication;

interface LoginNotifier
{
    public function sendLoginToken(LoginToken $token);
}
