<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mascota extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'tipo',
        'raza',
        'edad',
        'sexo',
        'user_id'
    ];

    //Relacion muchos a uno
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //Relacion uno a muchos
    public function informes()
    {
        return $this->hasMany(Informe::class);
    }
}
