<?php

namespace App\Http\Controllers\Api;

use App\Models\RefreshToken;
use Illuminate\Http\JsonResponse;

class RefreshTokenController
{
    public function __invoke(): JsonResponse
    {
        $refreshToken = request('refresh_token');

        if (!$refreshToken) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $token = RefreshToken::findToken($refreshToken);

        if (!$token){
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        if ($token->isExpired()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $tokenable = $token->tokenable;

        if (!$tokenable) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $token = auth()->tokenById($tokenable->id);

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);

    }
}
