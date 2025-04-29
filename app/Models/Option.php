<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $fillable = ['votation_id', 'option_text'];

    public function votation()
    {
        return $this->belongsTo(Votation::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }
}