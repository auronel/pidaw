<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Informe extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descripcion',
        'mascota_id'
    ];

    //Relacion muchos a uno
    public function mascota()
    {
        return $this->belongsTo(Mascota::class);
    }
}
