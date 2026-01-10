<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    public function seances()
    {
        return $this->hasMany(Seance::class);
    }

}
