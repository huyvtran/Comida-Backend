<?php

use App\Http\Controllers\API\UserController;
use Illuminate\Support\Facades\Route;

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

Route::prefix('auth')->group(function () {
    Route::post('login', [UserController::class, 'login']);
    Route::post('register', [UserController::class, 'register']);
    Route::post('verification', [UserController::class, 'verification']);
    Route::post('password/send', [UserController::class, 'send']);
    Route::put('password/reset', [UserController::class, 'reset']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [UserController::class, 'index']);
    Route::post('logout', [UserController::class, 'logout']);
    Route::put('profile/update', [UserController::class, 'update']);
});
