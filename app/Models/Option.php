<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $fillable = [
        'option_text',
        'votation_id',
    ];

    // Relación: una opción pertenece a una votación
    public function votation()
    {
        return $this->belongsTo(\App\Models\Votation::class);
    }

    // Relación: una opción tiene muchos votos
    public function votes()
    {
        return $this->hasMany(\App\Models\Vote::class);
    }
}