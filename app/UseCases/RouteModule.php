<?php

namespace App\UseCases;

use App\Http\Controllers\API\AuthController;
use Illuminate\Support\Facades\Route;

class RouteModule
{
    function __construct()
    {
        Route::middleware('auth:api')->group(function () {
            Route::match(['get', 'put'], '/me', [AuthController::class, 'me']);
            Route::post('/logout', [AuthController::class, 'logout']);
        });

        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/registration', [AuthController::class, 'registration']);
    }
}
