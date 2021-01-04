<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AuthController
{
    public function login(): JsonResponse
    {
        $credentials = request(['email', 'password']);

        if (! $accessToken = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $refreshToken = auth()->user()->createRefreshToken()->plainTextToken;

        return $this->respondWithToken($accessToken, $refreshToken);
    }

    public function me(): JsonResponse
    {
        return response()->json(auth()->user());
    }

    public function logout(): Response
    {
        auth()->logout();

        return response()->noContent();
    }

    protected function respondWithToken($accessToken, $refreshToken): JsonResponse
    {
        return response()->json([
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
