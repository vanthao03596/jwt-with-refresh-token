<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RefreshTokenController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);
Route::post('refresh', RefreshTokenController::class);

Route::middleware('auth:api')
    ->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('me', [AuthController::class, 'me']);
    });
