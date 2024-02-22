<?php

namespace App\Integrations\Interface;

// Define an interface that each authenticator will implement
interface AuthenticatorInterface
{
    /**
     * @param string $login
     * @param string $password
     * @return bool
     */
    public function authenticate(string $login, string $password): bool;
}
