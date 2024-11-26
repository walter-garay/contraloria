<?php

namespace Database\Factories;

use App\Models\Evaluacion;
use App\Models\Denuncia;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EvaluacionFactory extends Factory
{
    protected $model = Evaluacion::class;

    public function definition(): array
    {
        return [
            'denuncia_id' => Denuncia::factory(), // Crear denuncia asociada
            'user_id' => User::factory(), // Crear auditor asociado
            'observaciones' => $this->faker->paragraph, // Observaciones ficticias
            'resultado' => $this->faker->randomElement(['Desestimado', 'Pasa a Control']), // Resultado aleatorio
            'fecha_evaluacion' => $this->faker->dateTimeThisYear, // Fecha de evaluación
        ];
    }
}
