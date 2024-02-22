<?php

namespace App\Http\Controllers;

use App\Services\MovieService;
use Exception;
use Illuminate\Http\JsonResponse;

class MovieController extends Controller
{
    private MovieService $movieService;

    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }

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
