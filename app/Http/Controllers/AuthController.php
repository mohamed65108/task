<?php

namespace App\Http\Controllers;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Firebase\JWT\JWT;
use Symfony\Component\HttpFoundation\JsonResponse;

class AuthController extends Controller
{
    /**
     * @var AuthService
     */
    private AuthService $authService;

    /**
     * AuthController constructor.
     * @param AuthService $authService
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        if ($this->authService->login($request->login, $request->password)) {

            $token = $this->generateToken($request->login);

            return response()->json([
                'status' => 'success',
                'token' => $token
            ]);
        }

        return response()->json([
            'status' => 'failure',
        ], 401);
    }

    /**
     * @param string $login
     * @return string
     */
    private function generateToken(string $login): string
    {
        $payload = [
            'login' => $login,
            'company' => $this->authService->extractCompany($login),
            'exp' => time() + 3600 // Token expires in 1 hour
        ];
        return JWT::encode($payload, config('jwt.key'), 'HS256');
    }
}
