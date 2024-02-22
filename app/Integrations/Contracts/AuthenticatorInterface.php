<?php

namespace App\Integrations\Contracts;

interface AuthenticatorInterface
{
    public function authenticate(string $login, string $password): bool;
}
