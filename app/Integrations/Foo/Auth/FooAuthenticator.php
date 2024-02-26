<?php

namespace App\Integrations\Foo\Auth;

use App\Integrations\Contracts\AuthenticatorInterface;
use External\Foo\Auth\AuthWS;
use External\Foo\Exceptions\AuthenticationFailedException;

class FooAuthenticator implements AuthenticatorInterface
{
    public function authenticate(string $login, string $password): bool
    {
        try {
            $authenticator = new AuthWS();

            $authenticator->authenticate($login, $password);

            return true;
        } catch (AuthenticationFailedException) {
            return false;
        }
    }
}
