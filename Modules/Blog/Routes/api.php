<?php

use App\UseCases\RouteModule;
use Illuminate\Support\Facades\Route;
use Modules\Blog\Http\Controllers\API\ArticleController;
use Modules\Blog\Http\Controllers\API\UserArticleController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('blog-module')->middleware('module:blog')->group(function () {
    new RouteModule();

    Route::prefix('me')->middleware('auth:api')->group(function () {
        // apiResource/resource не работает из-за laravel-modules
        // Target class [Modules\Blog\Http\Controllers\Modules\Blog\Http\Controllers\ArticleController] does not exist.
        Route::prefix('articles')->group(function () {
            Route::get('/', [UserArticleController::class, 'index']);
            Route::get('/{id}', [UserArticleController::class, 'show']);
            Route::post('/', [UserArticleController::class, 'store']);
            Route::put('/{id}', [UserArticleController::class, 'update']);
            Route::delete('/{id}', [UserArticleController::class, 'destroy']);
        });
    });

    Route::get('/articles', [ArticleController::class, 'index']);
    Route::get('/articles/{id}', [ArticleController::class, 'show']);
});
