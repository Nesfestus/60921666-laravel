<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MovieControllerApi extends Controller
{
    public function index(Request $request): Response
    {
        $page = max(0, (int) $request->query('page', 0));
        $perpage = max(1, (int) $request->query('perpage', 5));

        return response(
            Movie::query()
                ->orderBy('id')
                ->offset($page * $perpage)
                ->limit($perpage)
                ->get()
        );
    }

    public function total(): Response
    {
        return response(Movie::count());
    }

    public function show(string $id): Response
    {
        return response(Movie::find($id));
    }
}
