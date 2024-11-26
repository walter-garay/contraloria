<?php

namespace Database\Factories;

use App\Models\Evaluacion;
use App\Models\Denuncia;
use App\Models\Auditor;
use Illuminate\Database\Eloquent\Factories\Factory;

class EvaluacionFactory extends Factory
{
    protected $model = Evaluacion::class;

    public function definition()
    {
        return [
            'denuncia_id' => Denuncia::factory(),  // Crea una denuncia asociada
            'auditor_id' => Auditor::factory(), // Crea un auditor asociado
            'observaciones' => $this->faker->paragraph, // Observaciones aleatorias
            'resultado' => $this->faker->randomElement(['Desestimado', 'Pasa a Control']), // Resultado aleatorio
            'fecha_evaluacion' => $this->faker->dateTimeThisYear, // Fecha de evaluación aleatoria
        ];
    }
}
