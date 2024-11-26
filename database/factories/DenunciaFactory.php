<?php

namespace Database\Factories;

use App\Models\Denuncia;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DenunciaFactory extends Factory
{
    protected $model = Denuncia::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // Asociar a un usuario
            'entidad' => $this->faker->company,
            'lugar' => $this->faker->city,
            'descripcion' => $this->faker->paragraph,
            'fecha_probable' => $this->faker->date,
            'prioridad' => $this->faker->randomElement([1, 2, 3, null]),
            'tipo_de_hecho' => $this->faker->sentence(3),
            'monto_economico' => $this->faker->randomFloat(2, 1000, 1000000),
            'otros_colaboradores' => $this->faker->text,
            'sigue_ocurriendo' => $this->faker->boolean,
            'estado' => $this->faker->randomElement(['En proceso', 'Admitido', 'No admitido', 'Derivado a OCI']),
        ];
    }
}
