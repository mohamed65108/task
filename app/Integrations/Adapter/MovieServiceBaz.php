<?php

namespace App\Integrations\Adapter;

use App\Exceptions\MovieServiceUnavailableException;
use App\Integrations\Interface\MovieServiceAdapterInterface;
use App\Traits\Retryable;
use Exception;
use External\Baz\Movies\MovieService;

class MovieServiceBaz implements MovieServiceAdapterInterface
{
    use Retryable;

    /**
     * @var MovieService
     */
    private MovieService $movieService;

    /**
     * MovieServiceBazA constructor.
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
                return $this->movieService->getTitles()['titles'];
            });
        } catch (Exception) {
            throw new MovieServiceUnavailableException();
        }
    }
}
