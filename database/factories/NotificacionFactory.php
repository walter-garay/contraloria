<?php

namespace Database\Factories;

use App\Models\Notificacion;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notificacion>
 */
class NotificacionFactory extends Factory
{
    protected $model = Notificacion::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(), // Asocia la notificación con un usuario aleatorio
            'mensaje' => $this->faker->sentence(), // Mensaje aleatorio
            'estado' => $this->faker->randomElement(['Leído', 'No leído']), // Estado aleatorio
        ];
    }
}
