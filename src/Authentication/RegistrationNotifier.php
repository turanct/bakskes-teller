<?php

namespace Teller\Authentication;

interface RegistrationNotifier
{
    public function notify(Registration $registration, Secret $secret);
}
