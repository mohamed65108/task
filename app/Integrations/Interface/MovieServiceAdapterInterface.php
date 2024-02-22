<?php

namespace App\Integrations\Interface;

// Define an interface that each movie service adapter will implement
interface MovieServiceAdapterInterface
{
    /**
     * @return mixed
     */
    public function getTitles(): mixed;
}
