<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Involucrado extends Model
{
    protected $table = 'involucrados';

    protected $fillable = [
        'denuncia_id',
        'nombre',
        'cargo',
        'entidad',
        'dni_ruc',
    ];

    // Relación con Denuncia
    public function denuncia()
    {
        return $this->belongsTo(Denuncia::class);
    }
}
