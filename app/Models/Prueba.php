<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prueba extends Model
{
    use HasFactory;

    protected $fillable = [
        'denuncia_id',
        'archivo',
        'descripcion',
    ];

    // Relación con Denuncia
    public function denuncia()
    {
        return $this->belongsTo(Denuncia::class);
    }
}
