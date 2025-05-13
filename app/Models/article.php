<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class article extends Model
{
    protected $fillable = [
        'code_article',
        'emplacement',
        'description',
        'prix_unitaire',
    ];
}
