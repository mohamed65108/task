<?php

namespace App\Integrations\Contracts;

interface MovieServiceAdapterInterface
{
    public function getTitles(): array;
}
