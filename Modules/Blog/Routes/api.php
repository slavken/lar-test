<?php

use App\UseCases\RouteModule;
use Illuminate\Support\Facades\Route;
use Modules\Blog\Http\Controllers\API\ArticleController;

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
        Route::apiResource('articles', '\Modules\Blog\Http\Controllers\API\UserArticleController');
    });

    Route::get('/articles', [ArticleController::class, 'index']);
    Route::get('/articles/{id}', [ArticleController::class, 'show']);
});
