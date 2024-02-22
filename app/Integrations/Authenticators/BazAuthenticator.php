<?php

namespace App\Integrations\Authenticators;

use App\Integrations\Contracts\AuthenticatorInterface;
use External\Baz\Auth\Authenticator;
use External\Baz\Auth\Responses\Success;

class BazAuthenticator implements AuthenticatorInterface
{
    public function authenticate(string $login, string $password): bool
    {
        $authenticatorBAZ = new Authenticator();

        return $authenticatorBAZ->auth($login, $password) instanceof Success;
    }
}
