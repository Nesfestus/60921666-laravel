<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seance extends Model
{
    public function hall()
    {
        return $this->belongsTo(Hall::class);
    }

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    public function prices()
    {
        return $this->hasMany(Price::class);
    }


// М↔М: проданные места (через tickets)
    public function seats()
    {
        return $this->belongsToMany(Seat::class, 'tickets')
            ->withPivot(['full_name'])
            ->withTimestamps();
    }

    protected $fillable = ['hall_id', 'movie_id', 'start_at'];


}
