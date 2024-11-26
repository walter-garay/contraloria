<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Denuncia;
use App\Models\Prueba;
use App\Models\Involucrado;
use App\Models\Evaluacion;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear un usuario específico para pruebas
        /*User::factory()->withPersonalTeam()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'rol' => 'Administrador', // Rol específico
            'is_active' => true,     // Usuario activo
        ]);*/

        // Crear otros 10 usuarios aleatorios
        User::factory(10)->create();
        
        // Crear 20 denuncias
        Denuncia::factory(20)->create();

        // Crear 30 pruebas asociadas a denuncias existentes
        Prueba::factory(30)->create();
        
        // Crear 30 involucrados asociados a denuncias existentes
        Involucrado::factory(30)->create();
        
        // Crear 15 evaluaciones asociadas a denuncias y auditores existentes
        Evaluacion::factory(15)->create();

    }
}
