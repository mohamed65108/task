<?php

namespace App\Integrations\Concrete;

use App\Integrations\Interface\AuthenticatorInterface;
use External\Baz\Auth\Authenticator;
use External\Baz\Auth\Responses\Success;

class BazAuthenticator implements AuthenticatorInterface
{
    /**
     * @param string $login
     * @param string $password
     * @return bool
     */
    public function authenticate(string $login, string $password): bool
    {
        $authenticatorBAZ = new Authenticator();
        $result = $authenticatorBAZ->auth($login, $password);
        return $result instanceof Success;
    }
}
