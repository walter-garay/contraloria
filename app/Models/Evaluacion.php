<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluacion extends Model
{
    protected $table = 'evaluaciones';

    protected $fillable = [
        'denuncia_id',
        'auditor_id',
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