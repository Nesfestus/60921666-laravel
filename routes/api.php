<?php

use App\Http\Controllers\HallControllerApi;
use App\Http\Controllers\MovieControllerApi;
use App\Http\Controllers\SeanceControllerApi;
use Illuminate\Support\Facades\Route;

Route::get('/movie', [MovieControllerApi::class, 'index']);
Route::get('/movie/{id}', [MovieControllerApi::class, 'show']);

Route::get('/hall', [HallControllerApi::class, 'index']);
Route::get('/hall/{id}', [HallControllerApi::class, 'show']);

Route::get('/seance', [SeanceControllerApi::class, 'index']);
Route::get('/seance/{id}', [SeanceControllerApi::class, 'show']);
