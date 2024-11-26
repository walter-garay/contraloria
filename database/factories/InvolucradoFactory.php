<?php

namespace Database\Factories;

use App\Models\Involucrado;
use App\Models\Denuncia;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvolucradoFactory extends Factory
{
    protected $model = Involucrado::class;

    public function definition(): array
    {
        return [
            'denuncia_id' => Denuncia::factory(), // Asociar a una denuncia existente
            'nombre' => $this->faker->name, // Nombre ficticio
            'cargo' => $this->faker->jobTitle, // Cargo ficticio
            'entidad' => $this->faker->company, // Entidad ficticia
            'dni_ruc' => $this->faker->randomNumber(8, true), // DNI o RUC ficticio
        ];
    }
}
