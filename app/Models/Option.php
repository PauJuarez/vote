<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Votation;
use App\Models\Vote;

class Option extends Model
{
    public function votation()
    {
        return $this->belongsTo(Votation::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }}
