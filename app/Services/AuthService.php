<?php

namespace App\Services;

use App\Integrations\Concrete\BarAuthenticator;
use App\Integrations\Concrete\BazAuthenticator;
use App\Integrations\Concrete\FooAuthenticator;
use App\Integrations\Interface\AuthenticatorInterface;

class AuthService
{
    /**
     * @param string $login
     * @param string $password
     * @return bool
     */
    public function login(string $login, string $password): bool
    {
        $authenticator = $this->createAuthenticator($login);
        if (is_null($authenticator)) {
            return false;
        }
        return $authenticator->authenticate($login, $password);
    }

    /**
     * @param string $login
     * @return AuthenticatorInterface|null
     */
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

    /**
     * @param string $login
     * @return string|null
     */
    public function extractCompany(string $login): ?string
    {
        if (preg_match("/^FOO_.*/", $login)) {
            return "FOO";
        } elseif (preg_match("/^BAR_.*/", $login)) {
            return "BAR";
        } elseif (preg_match("/^BAZ_.*/", $login)) {
            return "BAZ";
        } else {
            return null;
        }
    }
}
