<?php

namespace App\Integrations\Adapter;

use App\Exceptions\MovieServiceUnavailableException;
use App\Integrations\Interface\MovieServiceAdapterInterface;
use App\Traits\Retryable;
use Exception;
use External\Foo\Movies\MovieService;

class MovieServiceFoo implements MovieServiceAdapterInterface
{
    use Retryable;

    /**
     * @var MovieService
     */
    private MovieService $movieService;

    /**
     * MovieServiceFoo constructor.
     * @param MovieService $movieService
     */
    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }

    /**
     * @return array
     * @throws MovieServiceUnavailableException
     */
    public function getTitles(): array
    {
        try {
            return $this->retry(function () {
                return $this->movieService->getTitles();
            });
        } catch (Exception) {
            throw new MovieServiceUnavailableException();
        }
    }
}
