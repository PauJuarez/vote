<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Vote;
use App\Models\Option;


class Votation extends Model
{
    use HasFactory;
    protected $fillable = ['title','description','start_date','end_date','created_at','user_id'];
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }
    public function options()
    {
        return $this->hasMany(Option::class);
    }
    
}
