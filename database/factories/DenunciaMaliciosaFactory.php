<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\DenunciaMaliciosa;
use App\Models\Denuncia;

class DenunciaMaliciosaFactory extends Factory
{
    protected $model = DenunciaMaliciosa::class;

    public function definition()
    {
        return [
            'denuncia_id' => Denuncia::factory(), // Asocia la denuncia maliciosa con una denuncia aleatoria
            'razon' => $this->faker->paragraph(), // Razón aleatoria
            'sancion' => $this->faker->randomFloat(2, 50, 500), // Sanción aleatoria entre 50 y 500
        ];
    }
}