<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $table = 'Vote'; // Mejor dejar el nombre en minúscula plural

    protected $fillable = ['votation_id', 'option_id', 'user_id'];

    public function option()
    {
        return $this->belongsTo(Option::class);
    }

    public function votation()
    {
        return $this->belongsTo(Votation::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}