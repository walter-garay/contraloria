<?php

namespace Database\Factories;

use App\Models\Denuncia;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Denuncia>
 */
class DenunciaFactory extends Factory
{
    protected $model = Denuncia::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(), // Asociar la denuncia con un usuario aleatorio
            'entidad' => $this->faker->company, // Nombre de la entidad
            'lugar' => $this->faker->address, // Dirección o lugar del incidente
            'descripcion' => $this->faker->paragraph, // Descripción del hecho
            'fecha_probable' => $this->faker->date, // Fecha probable del hecho
            'prioridad' => $this->faker->optional()->numberBetween(1, 5), // Prioridad (opcional)
            'tipo_de_hecho' => $this->faker->optional()->word, // Tipo de hecho (opcional)
            'monto_economico' => $this->faker->optional()->randomFloat(2, 1000, 10000), // Monto económico (opcional)
            'otros_colaboradores' => $this->faker->optional()->paragraph, // Otros colaboradores (opcional)
            'sigue_ocurriendo' => $this->faker->optional()->boolean, // Si sigue ocurriendo (opcional)
            'estado' => $this->faker->randomElement(['En proceso', 'Admitido', 'No admitido', 'Derivado a OCI']), // Estado de la denuncia
        ];
    }
}
