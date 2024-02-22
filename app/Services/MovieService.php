<?php

namespace App\Services;

use App\Exceptions\MovieServiceUnavailableException;
use App\Integrations\Adapter\MovieServiceBar;
use App\Integrations\Adapter\MovieServiceBaz;
use App\Integrations\Adapter\MovieServiceFoo;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class MovieService
{

    /**
     * @var MovieServiceFoo
     */
    private MovieServiceFoo $movieServiceFoo;

    /**
     * @var MovieServiceBar
     */
    private MovieServiceBar $movieServiceBar;

    /**
     * @var MovieServiceBaz
     */
    private MovieServiceBaz $movieServiceBaz;

    /**
     * MovieService constructor.
     * @param MovieServiceFoo $movieServiceFoo
     * @param MovieServiceBar $movieServiceBar
     * @param MovieServiceBaz $movieServiceBaz
     */
    public function __construct(
        MovieServiceFoo $movieServiceFoo,
        MovieServiceBar $movieServiceBar,
        MovieServiceBaz $movieServiceBaz
    )
    {
        $this->movieServiceFoo = $movieServiceFoo;
        $this->movieServiceBar = $movieServiceBar;
        $this->movieServiceBaz = $movieServiceBaz;
    }

    /**
     * @return array
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws MovieServiceUnavailableException
     */
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

    /**
     * @param callable $callable
     * @param string $cacheKey
     * @param int $ttl
     * @return mixed
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getCachedOrCall(callable $callable, string $cacheKey, int $ttl = 60): mixed
    {
        // Check if the result is cached
        if (cache()->has($cacheKey)) {
            return cache()->get($cacheKey);
        }

        // Call the movie service
        $result = $callable();

        // Cache the result for 60 seconds
        cache()->put($cacheKey, $result, $ttl);

        return $result;
    }
}
