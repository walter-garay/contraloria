<?php

namespace Database\Factories;

use App\Models\Prueba;
use App\Models\Denuncia;
use Illuminate\Database\Eloquent\Factories\Factory;

class PruebaFactory extends Factory
{
    protected $model = Prueba::class;

    public function definition()
    {
        return [
            'denuncia_id' => Denuncia::factory(),  // Crea una denuncia asociada
            'archivo' => $this->faker->word . '.pdf', // Nombre de archivo aleatorio
            'descripcion' => $this->faker->text(200), // Descripción aleatoria
        ];
    }
}
