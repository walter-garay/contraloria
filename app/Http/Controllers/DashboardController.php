<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Denuncia;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        // Datos de usuarios
        $totalUsuarios = User::count();
        $usuariosPorRol = User::select('rol', DB::raw('COUNT(*) as total'))
            ->groupBy('rol')
            ->get();
        $usuariosActivos = User::where('is_active', true)->count();
        $usuariosInactivos = $totalUsuarios - $usuariosActivos;

        // Datos de denuncias
        $totalDenuncias = Denuncia::count();
        $denunciasPorEstado = Denuncia::select('estado', DB::raw('COUNT(*) as total'))
            ->groupBy('estado')
            ->get();
        $denunciasPorPrioridad = Denuncia::select('prioridad', DB::raw('COUNT(*) as total'))
            ->groupBy('prioridad')
            ->get();

        // Pasar datos a la vista
        return Inertia::render('Dashboard/Index', [
            'totalUsuarios' => $totalUsuarios,
            'usuariosPorRol' => $usuariosPorRol,
            'usuariosActivos' => $usuariosActivos,
            'usuariosInactivos' => $usuariosInactivos,
            'totalDenuncias' => $totalDenuncias,
            'denunciasPorEstado' => $denunciasPorEstado,
            'denunciasPorPrioridad' => $denunciasPorPrioridad,
        ]);
    }
}
