<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $fillable = ['paiement_id', 'statut', 'date_transaction'];

    public function paiement(): BelongsTo
    {
        return $this->belongsTo(Paiement::class);
    }
}
