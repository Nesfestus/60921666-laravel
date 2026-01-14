<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HallController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\SeanceController;
use App\Http\Controllers\SeatController;
use App\Http\Controllers\LoginController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/hello', function () {
    return view('hello', ['title' => 'Hello world!']);
});


//Auth routes (public)
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/auth', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

// ERROR page (для Gate)
Route::get('/error', function () {
    return view('error', ['message' => session('message')]);
});

//Public pages (необязательно защищать)
Route::get('/halls', [HallController::class, 'index']);
Route::get('/halls/{id}', [HallController::class, 'show']);

Route::get('/movies', [MovieController::class, 'index']);
Route::get('/movies/{id}', [MovieController::class, 'show']);

//Protected routes (auth middleware)
Route::middleware('auth')->group(function () {

    // CRUD seances (важен порядок)
    Route::get('/seances', [SeanceController::class, 'index']);
    Route::get('/seances/create', [SeanceController::class, 'create']);
    Route::post('/seances', [SeanceController::class, 'store']);

    Route::get('/seances/edit/{id}', [SeanceController::class, 'edit']);
    Route::post('/seances/update/{id}', [SeanceController::class, 'update']);

    Route::get('/seances/destroy/{id}', [SeanceController::class, 'destroy']);

    // show seance
    Route::get('/seances/{id}', [SeanceController::class, 'show']);

    // seat show (тоже защита)
    Route::get('/seats/{id}', [SeatController::class, 'show']);

    //error защита
    Route::get('/error', function () {
        return view('error', ['message' => session('message')]);
    })->middleware('auth');
});
