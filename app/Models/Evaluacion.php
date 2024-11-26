<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluacion extends Model
{
    use HasFactory; // Agregar este trait

    protected $table = 'evaluaciones';

    protected $fillable = [
        'denuncia_id',
        'user_id',
        'observaciones',
        'resultado',
        'fecha_evaluacion',
    ];

    // Relación con Denuncia
    public function denuncia()
    {
        return $this->belongsTo(Denuncia::class);
    }

    // Relación con Auditor
    public function auditor()
    {
        return $this->belongsTo(Auditor::class);
    }
}
