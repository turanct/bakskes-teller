<?php

namespace Teller\Web;

use Teller\Authentication\RegistrationService;
use Symfony\Component\HttpFoundation\Request;

final class RegistrationController
{
    private $registrationService;

    public function __construct(RegistrationService $registrationService)
    {
        $this->registrationService = $registrationService;
    }

    public function registerForm()
    {
        return '<html>
            <body>
                <form action="/register" method="post">
                    <input type="text" name="name" placeholder="name">
                    <input type="text" name="email" placeholder="email">
                    <input type="submit">
                </form>
            </body>
        </html>';
    }

    public function register(Request $request)
    {
        $this->registrationService->register(
            $request->get('name'),
            $request->get('email')
        );

        return 'registered! check mail';
    }

    public function confirm($email, $secret)
    {
        $this->registrationService->confirm($email, $secret);

        return 'confirmed';
    }
}
