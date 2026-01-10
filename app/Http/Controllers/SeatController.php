<?php

namespace App\Http\Controllers;

use App\Models\Seat;

class SeatController extends Controller
{
    public function show(string $id)
    {
        return view('seat', [
            'seat' => Seat::with(['hall','seances.movie'])->where('id', $id)->first()
        ]);
    }
}
