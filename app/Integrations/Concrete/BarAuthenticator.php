<?php

namespace App\Integrations\Concrete;

use App\Integrations\Interface\AuthenticatorInterface;
use External\Bar\Auth\LoginService;

class BarAuthenticator implements AuthenticatorInterface
{
    /**
     * @param string $login
     * @param string $password
     * @return bool
     */
    public function authenticate(string $login, string $password): bool
    {
        $authenticatorBAR = new LoginService();
        return $authenticatorBAR->login($login, $password);
    }
}
