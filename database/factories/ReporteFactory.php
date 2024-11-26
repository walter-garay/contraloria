<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Reporte;

class ReporteFactory extends Factory
{
    protected $model = Reporte::class;

    public function definition()
    {
        return [
            'titulo' => $this->faker->sentence(), // Titulo aleatorio
            'descripcion' => $this->faker->paragraph(), // Descripción aleatoria
            'archivo' => $this->faker->filePath(), // Archivo aleatorio (puedes modificar esto para usar una ruta válida o generar un nombre de archivo)
        ];
    }
}
