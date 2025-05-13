<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Produit extends Model
{
    protected $fillable = ['nom', 'description', 'prix', 'stock','image'];

    public function ligneCommandes(): HasMany
    {
        return $this->hasMany(LigneCommande::class);
    }
}
