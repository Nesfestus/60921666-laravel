<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/hello', function () {
    return view('hello', ['title' => 'Hello world!']);
});

use App\Http\Controllers\HallController;
use App\Http\Controllers\MovieController;

Route::get('/halls', [HallController::class, 'index']);
Route::get('/halls/{id}', [HallController::class, 'show']);

Route::get('/movies', [MovieController::class, 'index']);
Route::get('/movies/{id}', [MovieController::class, 'show']);

use App\Http\Controllers\SeanceController;
use App\Http\Controllers\SeatController;

Route::get('/seances/{id}', [SeanceController::class, 'show']);
Route::get('/seats/{id}', [SeatController::class, 'show']);
