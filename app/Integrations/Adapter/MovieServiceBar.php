<?php

namespace App\Integrations\Adapter;

use App\Exceptions\MovieServiceUnavailableException;
use App\Integrations\Interface\MovieServiceAdapterInterface;
use App\Traits\Retryable;
use Exception;
use External\Bar\Movies\MovieService;

class MovieServiceBar implements MovieServiceAdapterInterface
{
    use Retryable;

    /**
     * @var MovieService
     */
    private MovieService $movieService;

    /**
     * MovieServiceBar constructor.
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
                $titles = $this->movieService->getTitles()['titles'];
                return array_column($titles, 'title');
            });
        } catch (Exception) {
            throw new MovieServiceUnavailableException();
        }
    }
}
