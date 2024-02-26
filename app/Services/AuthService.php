<?php

namespace App\Services;

use App\Integrations\Contracts\AuthenticatorInterface;
use App\Integrations\Bar\Auth\BarAuthenticator;
use App\Integrations\Baz\Auth\BazAuthenticator;
use App\Integrations\Foo\Auth\FooAuthenticator;

class AuthService
{
    public function login(string $login, string $password): bool
    {
        $authenticator = $this->createAuthenticator($login);
        if (is_null($authenticator)) {
            return false;
        }

        return $authenticator->authenticate($login, $password);
    }

    private function createAuthenticator(string $login): ?AuthenticatorInterface
    {
        $company = $this->extractCompany($login);

        return match ($company) {
            'FOO' => new FooAuthenticator(),
            'BAR' => new BarAuthenticator(),
            'BAZ' => new BazAuthenticator(),
            default => null,
        };
    }

    public function extractCompany(string $login): ?string
    {
        if (preg_match('/^(FOO|BAR|BAZ)_/', $login, $matches)) {
            return $matches[1];
        } else {
            return null;
        }
    }
}
