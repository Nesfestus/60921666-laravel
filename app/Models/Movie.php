<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{

    protected $fillable = [
        'name',
        'duration',
        'picture_url',
    ];
    public function seances()
    {
        return $this->hasMany(Seance::class);
    }

}
