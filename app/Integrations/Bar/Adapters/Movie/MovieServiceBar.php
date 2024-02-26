<?php

namespace App\Integrations\Bar\Adapters\Movie;

use App\Exceptions\MovieServiceUnavailableException;
use App\Integrations\Contracts\MovieServiceAdapterInterface;
use App\Traits\Retryable;
use Exception;
use External\Bar\Movies\MovieService;

class MovieServiceBar implements MovieServiceAdapterInterface
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
                $titles = $this->movieService->getTitles()['titles'];

                return array_column($titles, 'title');
            });
        } catch (Exception) {
            throw new MovieServiceUnavailableException();
        }
    }
}
