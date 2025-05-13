<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Voyage extends Model
{
    protected $fillable = ['destination', 'date_debut', 'date_fin', 'prix','image'];

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }
}

