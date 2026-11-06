<?php

namespace App\Http\Controllers;

use App\Models\Seance;
use Illuminate\Http\Response;

class SeanceControllerApi extends Controller
{
    public function index(): Response
    {
        return response(Seance::all());
    }

    public function show(string $id): Response
    {
        return response(Seance::find($id));
    }
}
