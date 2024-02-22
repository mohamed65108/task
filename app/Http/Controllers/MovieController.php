<?php

namespace App\Http\Controllers;

use App\Exceptions\MovieServiceUnavailableException;
use App\Services\MovieService;
use Exception;
use Illuminate\Http\JsonResponse;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class MovieController extends Controller
{
    /**
     * @var MovieService
     */
    private MovieService $movieService;

    /**
     * MovieController constructor.
     * @param MovieService $movieService
     */
    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }

    /**
     * @return JsonResponse
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws MovieServiceUnavailableException
     */
    public function getTitles(): JsonResponse
    {
        try {
            $titles = $this->movieService->getTitles();
            return response()->json($titles);
        } catch (Exception) {
            return response()->json(['status' => 'failure'], 500);
        }
    }
}
