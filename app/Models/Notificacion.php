<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notificacion extends Model
{
    use HasFactory;

    // Especificamos que la tabla se llama 'notificaciones' (aunque Laravel la toma por defecto)
    protected $table = 'notificaciones';

    // Los campos que son asignables en masa
    protected $fillable = [
        'user_id', 
        'mensaje', 
        'estado'
    ];

    // Define la relación con el modelo User (un usuario puede tener muchas notificaciones)
    public function user()
    {
        return $this->belongsTo(User::class); // Relación inversa, cada notificación pertenece a un usuario
    }
}
