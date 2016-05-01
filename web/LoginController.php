<?php

namespace Teller\Web;

use Teller\Authentication\LoginService;
use Symfony\Component\HttpFoundation\Request;

final class LoginController
{
    private $loginService;

    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    public function loginForm()
    {
        return '<html>
            <body>
                <form action="/login" method="post">
                    <input type="text" name="email" placeholder="email">
                    <input type="submit">
                </form>
            </body>
        </html>';
    }

    public function login(Request $request)
    {
        $this->loginService->requestToken(
            $request->get('email')
        );

        return 'token requested! check mail';
    }

    public function activateToken($secret)
    {
        $this->loginService->activateToken($secret);

        // TODO: try/catch block with session stuff

        return 'logged in';
    }
}
