<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    public function hall()
    {
        return $this->belongsTo(Hall::class);
    }

// М↔М: на каких сеансах место было продано (через tickets)
    public function seances()
    {
        return $this->belongsToMany(Seance::class, 'tickets')
            ->withPivot(['full_name'])
            ->withTimestamps();
    }

}
