<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'fecha',
        'hora',
        'user_id'
    ];

    //Relacion muchos a uno
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
