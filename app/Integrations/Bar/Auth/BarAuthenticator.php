<?php

namespace App\Integrations\Bar\Auth;

use App\Integrations\Contracts\AuthenticatorInterface;
use External\Bar\Auth\LoginService;

class BarAuthenticator implements AuthenticatorInterface
{
    public function authenticate(string $login, string $password): bool
    {
        $authenticatorBAR = new LoginService();

        return $authenticatorBAR->login($login, $password);
    }
}
