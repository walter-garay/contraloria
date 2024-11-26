<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Denuncia extends Model
{
    use HasFactory;

    /**
     * Los atributos que se pueden asignar masivamente.
     */
    protected $fillable = [
        'user_id',
        'entidad',
        'lugar',
        'descripcion',
        'fecha_probable',
        'prioridad',
        'tipo_de_hecho',
        'monto_economico',
        'otros_colaboradores',
        'sigue_ocurriendo',
        'estado',
    ];

    /**
     * Relación con el modelo User.
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relación con el modelo Prueba.
     */
    public function pruebas()
    {
        return $this->hasMany(related: Prueba::class, 'denuncia_id');
    }

    /**
     * Relación con el modelo Involucrado.
     */
    public function involucrados()
    {
        return $this->hasMany(Involucrado::class, 'denuncia_id');
    }

    /**
     * Relación con el modelo Evaluacion.
     */
    public function evaluaciones()
    {
        return $this->hasMany(Evaluacion::class, 'denuncia_id');
    }

    /**
     * Relación con el modelo DenunciaMaliciosa.
     */
    public function denunciaMaliciosa()
    {
        return $this->hasOne(DenunciaMaliciosa::class, 'denuncia_id');
    }
}
