<?php

namespace App\Http\Controllers;

use App\Models\Hall;
use Illuminate\Http\Response;

class HallControllerApi extends Controller
{
    public function index(): Response
    {
        return response(Hall::all());
    }

    public function show(string $id): Response
    {
        return response(Hall::find($id));
    }
}
