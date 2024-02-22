<?php

namespace App\Services;

use App\Integrations\Adapters\MovieServiceBar;
use App\Integrations\Adapters\MovieServiceBaz;
use App\Integrations\Adapters\MovieServiceFoo;

class MovieService
{
    private MovieServiceFoo $movieServiceFoo;

    private MovieServiceBar $movieServiceBar;

    private MovieServiceBaz $movieServiceBaz;

    public function __construct(
        MovieServiceFoo $movieServiceFoo,
        MovieServiceBar $movieServiceBar,
        MovieServiceBaz $movieServiceBaz
    ) {
        $this->movieServiceFoo = $movieServiceFoo;
        $this->movieServiceBar = $movieServiceBar;
        $this->movieServiceBaz = $movieServiceBaz;
    }

    public function getTitles(): array
    {
        // Get titles from Foo service
        $fooTitles = $this->getCachedOrCall([$this->movieServiceFoo, 'getTitles'], 'foo_titles');

        // Get titles from Bar service
        $barTitles = $this->getCachedOrCall([$this->movieServiceBar, 'getTitles'], 'bar_titles');

        // Get titles from Baz service
        $bazTitles = $this->getCachedOrCall([$this->movieServiceBaz, 'getTitles'], 'baz_titles');

        // merge and return the titles
        return array_merge($fooTitles, $barTitles, $bazTitles);
    }

    public function getCachedOrCall(callable $callable, string $cacheKey, int $ttl = 60): mixed
    {
        if (cache()->has($cacheKey)) {
            return cache()->get($cacheKey);
        }

        $result = $callable();

        cache()->put($cacheKey, $result, $ttl);

        return $result;
    }
}
