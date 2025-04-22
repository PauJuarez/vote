<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Votations extends Model
{
    use HasFactory;
    protected $fillable = ['title','description','start_date','end_date','created_at','user_id'];
}
