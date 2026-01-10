<?php

namespace App\Http\Controllers;

use App\Models\Movie;

class MovieController extends Controller
{
    public function index()
    {
        return view('movies', [
            'movies' => Movie::all()
        ]);
    }

    public function show(string $id)
    {
        return view('movie', [
            'movie' => Movie::with('seances')->where('id', $id)->first()
        ]);
    }
}
