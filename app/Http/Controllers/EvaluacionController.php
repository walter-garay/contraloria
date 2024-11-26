<?php

namespace App\Http\Controllers;

use App\Models\Evaluacion;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;


class EvaluacionController extends Controller
{
    // Reglas de validación separadas
    private $rules = [
        'store' => [
            'denuncia_id' => 'required|integer|exists:denuncias,id',
            'user_id' => 'required|integer|exists:users,id', // Relacionado con User, no Auditor
            'observaciones' => 'required|string|max:500',
            'resultado' => 'required|in:Desestimado,Pasa a Control',
            'fecha_evaluacion' => 'required|date',
        ],
        'update' => [
            'denuncia_id' => 'required|integer|exists:denuncias,id',
            'user_id' => 'required|integer|exists:users,id', // Relacionado con User, no Auditor
            'observaciones' => 'required|string|max:500',
            'resultado' => 'required|in:Desestimado,Pasa a Control',
            'fecha_evaluacion' => 'required|date',
        ],
    ];

    // Listar evaluaciones
    public function index()
    {
        $evaluaciones = Evaluacion::with('denuncia', 'usuario') // 'usuario' en lugar de 'auditor'
            ->select('id', 'denuncia_id', 'user_id', 'observaciones', 'resultado', 'fecha_evaluacion', 'updated_at')
            ->orderBy('id', 'desc')
            ->get();

        return Inertia::render('Evaluaciones/Index', [
            'evaluaciones' => $evaluaciones,
        ]);
    }

    // Crear una evaluación
    public function store(Request $request)
    {
        $request->validate($this->rules['store']);

        Evaluacion::create($request->all());

        return response()->json(['success' => true, 'message' => 'Evaluación creada exitosamente.']);
    }

    // Actualizar una evaluación
    public function update(Request $request, Evaluacion $evaluacion)
    {
        $request->validate($this->rules['update']);

        $evaluacion->update($request->all());

        return response()->json(['success' => true, 'message' => 'Evaluación actualizada exitosamente.']);
    }

    // Eliminar una evaluación
    public function destroy(Evaluacion $evaluacion)
    {
        $evaluacion->delete();

        return response()->json(['success' => true, 'message' => 'Evaluación eliminada exitosamente.']);
    }

    // Devuelve la lista de evaluaciones en JSON
    public function getEvaluaciones()
    {
        return Evaluacion::select('id', 'denuncia_id', 'user_id', 'observaciones', 'resultado', 'fecha_evaluacion')
            ->orderBy('fecha_evaluacion', 'desc')
            ->get();
    }

    // Exportar evaluaciones a CSV
    public function export()
    {
        $evaluaciones = Evaluacion::all();
        $csvExporter = new \Laracsv\Export();
        $csvExporter->build($evaluaciones, ['id', 'denuncia_id', 'user_id', 'observaciones', 'resultado', 'fecha_evaluacion', 'created_at'])->download();
    }

    // Importar evaluaciones desde CSV
    public function import(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|mimes:csv,txt',
            ]);

            // Implementar el importador aquí, si es necesario.
            Excel::import(new EvaluacionesImport, $request->file('file'));

            return response()->json(['success' => true, 'message' => 'Evaluaciones importadas correctamente.']);
        } catch (\Exception $e) {
            Log::error('Error al importar evaluaciones: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al importar evaluaciones.'], 500);
        }
    }
}
