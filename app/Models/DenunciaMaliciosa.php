<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DenunciaMaliciosa extends Model
{
    use HasFactory;

    // Los campos que se pueden asignar masivamente
    protected $fillable = [
        'denuncia_id', 
        'razon', 
        'sancion'
    ];

    // Relación con el modelo Denuncia (suponiendo que tienes un modelo Denuncia)
    public function denuncia()
    {
        return $this->belongsTo(Denuncia::class); // Relación inversa, cada denuncia maliciosa pertenece a una denuncia
    }
}
