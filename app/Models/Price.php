<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    public function seance()
    {
        return $this->belongsTo(Seance::class);
    }

}
