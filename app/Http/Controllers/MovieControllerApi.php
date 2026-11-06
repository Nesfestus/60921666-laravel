<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Response;

class MovieControllerApi extends Controller
{
    public function index(): Response
    {
        return response(Movie::all());
    }

    public function show(string $id): Response
    {
        return response(Movie::find($id));
    }
}
