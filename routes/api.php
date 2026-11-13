<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HallControllerApi;
use App\Http\Controllers\MovieControllerApi;
use App\Http\Controllers\SeanceControllerApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Открытые маршруты
Route::post('/login', [AuthController::class, 'login']);

Route::get('/movie/{id}', [MovieControllerApi::class, 'show']);

Route::get('/hall', [HallControllerApi::class, 'index']);
Route::get('/halls_total', [HallControllerApi::class, 'total']);
Route::get('/hall/{id}', [HallControllerApi::class, 'show']);

Route::get('/seance', [SeanceControllerApi::class, 'index']);
Route::get('/seance/{id}', [SeanceControllerApi::class, 'show']);

// Защищённые маршруты
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/movie', [MovieControllerApi::class, 'index']);
    Route::post('/movie', [MovieControllerApi::class, 'store']);
    Route::delete('/movie/{id}', [MovieControllerApi::class, 'destroy']);
    Route::post('/movie/{id}', [MovieControllerApi::class, 'update']);
    Route::get('/movies_total', [MovieControllerApi::class, 'total']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [AuthController::class, 'logout']);

});
