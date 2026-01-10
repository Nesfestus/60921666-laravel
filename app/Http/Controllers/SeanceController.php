<?php

namespace App\Http\Controllers;

use App\Models\Seance;

class SeanceController extends Controller
{
    public function show(string $id)
    {
        return view('seance', [
            'seance' => Seance::with(['movie','hall','seats'])->where('id', $id)->first()
        ]);
    }
}
