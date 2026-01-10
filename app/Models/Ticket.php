<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    public function seance()
    {
        return $this->belongsTo(Seance::class);
    }

    public function seat()
    {
        return $this->belongsTo(Seat::class);
    }

}
