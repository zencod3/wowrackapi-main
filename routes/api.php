<?php

use App\Http\Controllers\HotspotController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::post('/users/register', [\App\Http\Controllers\UserController::class, 'register']);
Route::post('/users/login', [\App\Http\Controllers\UserController::class, 'login']);
Route::post('/services', [\App\Http\Controllers\ServiceController::class, 'createService']);

Route::get('/hotspots', [HotspotController::class, 'index']);
Route::get('/hotspots/{hotspot}', [HotspotController::class, 'show']);
Route::post('/hotspots', [HotspotController::class, 'store']);

Route::middleware(\App\Http\Middleware\ApiAuthMiddleware::class)->group(function () {
    Route::post('/users/otp', [\App\Http\Controllers\LoginOtpController::class, 'login_verification']);
    Route::get('/users/current', [\App\Http\Controllers\UserController::class, 'getUser']);
    Route::post('/users/logout', [\App\Http\Controllers\UserController::class, 'logout']);


    Route::post('/articles', [\App\Http\Controllers\ArticleController::class, 'createArticle']);
    Route::get('/articles', [\App\Http\Controllers\ArticleController::class, 'getArticle']);
    Route::get('/articles/{id}', [\App\Http\Controllers\ArticleController::class, 'getArticleById'])
        ->where('id', '[0-9]+');
    Route::get('/services', [\App\Http\Controllers\ServiceController::class, 'getService']);


    Route::post('/subscription/{idUser}', [\App\Http\Controllers\SubscriptionController::class, 'createSubscription'])
        ->where('idUser', '[0-9]+');
    Route::get('/subscription', [\App\Http\Controllers\SubscriptionController::class, 'getSubscriptionsByUserId']);

});
