<?php

namespace Teller\Authentication;

interface RegistrationRepository
{
    public function persist(Registration $registration);
    public function getByEmail($email);
}
