<?php

namespace App\Integrations\Concrete;

use App\Integrations\Interface\AuthenticatorInterface;
use External\Foo\Auth\AuthWS;
use External\Foo\Exceptions\AuthenticationFailedException;

class FooAuthenticator implements AuthenticatorInterface
{
    /**
     * @param string $login
     * @param string $password
     * @return bool
     */
    public function authenticate(string $login, string $password): bool
    {
        $authenticator = new AuthWS();
        try {
            $authenticator->authenticate($login, $password);
            return true;
        } catch (AuthenticationFailedException) {
            return false;
        }
    }
}
