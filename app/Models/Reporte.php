<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reporte extends Model
{
    use HasFactory;

    // Los campos que se pueden asignar masivamente
    protected $fillable = [
        'titulo', 
        'descripcion', 
        'archivo'
    ];
}
