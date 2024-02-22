<?php

namespace App\Integrations\Adapters;

use App\Exceptions\MovieServiceUnavailableException;
use App\Integrations\Contracts\MovieServiceAdapterInterface;
use App\Traits\Retryable;
use Exception;
use External\Baz\Movies\MovieService;

class MovieServiceBaz implements MovieServiceAdapterInterface
{
    use Retryable;

    private MovieService $movieService;

    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }

    /**
     * @throws MovieServiceUnavailableException
     */
    public function getTitles(): array
    {
        try {
            return $this->retry(function () {
                return $this->movieService->getTitles()['titles'];
            });
        } catch (Exception) {
            throw new MovieServiceUnavailableException();
        }
    }
}
