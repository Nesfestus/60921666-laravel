<?php

namespace App\Http\Controllers;

use App\Models\Hall;

class HallController extends Controller
{
    public function index()
    {
        return view('halls', [
            'halls' => Hall::all()
        ]);
    }

    public function show(string $id)
    {
        return view('hall', [
            'hall' => Hall::with('seats')->where('id', $id)->first()
        ]);
    }
}
