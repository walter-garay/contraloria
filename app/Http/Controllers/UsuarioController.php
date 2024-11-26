<?php

namespace App\Http\Controllers;

use App\Models\Denuncia;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DenunciasImport;
use App\Exports\DenunciasExport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class DenunciaController extends Controller
{
    // Reglas de validación para almacenar y actualizar
    private $rules = [
        'store' => [
            'entidad' => 'required|max:255',
            'lugar' => 'required|max:255',
            'descripcion' => 'required',
            'fecha_probable' => 'required|date',
            'prioridad' => 'nullable|integer',
            'tipo_de_hecho' => 'nullable|max:255',
            'monto_economico' => 'nullable|numeric',
            'otros_colaboradores' => 'nullable|max:255',
            'sigue_ocurriendo' => 'nullable|boolean',
            'estado' => 'required|in:En proceso,Admitido,No admitido,Derivado a OCI',
        ],
        'update' => [
            'entidad' => 'required|max:255',
            'lugar' => 'required|max:255',
            'descripcion' => 'required',
            'fecha_probable' => 'required|date',
            'prioridad' => 'nullable|integer',
            'tipo_de_hecho' => 'nullable|max:255',
            'monto_economico' => 'nullable|numeric',
            'otros_colaboradores' => 'nullable|max:255',
            'sigue_ocurriendo' => 'nullable|boolean',
            'estado' => 'required|in:En proceso,Admitido,No admitido,Derivado a OCI',
        ],
    ];

    // Listar todas las denuncias
    public function index()
    {
        $denuncias = Denuncia::with('usuario') // Cargar la relación con el usuario que creó la denuncia
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('Denuncias/Index', [
            'denuncias' => $denuncias,
        ]);
    }

    // Crear una nueva denuncia
    public function store(Request $request)
    {
        // Validación de datos
        $request->validate($this->rules['store']);

        // Crear una nueva denuncia en la base de datos
        $denuncia = Denuncia::create([
            'user_id' => Auth::id(), // Usuario autenticado
            'entidad' => $request->entidad,
            'lugar' => $request->lugar,
            'descripcion' => $request->descripcion,
            'fecha_probable' => $request->fecha_probable,
            'prioridad' => $request->prioridad,
            'tipo_de_hecho' => $request->tipo_de_hecho,
            'monto_economico' => $request->monto_economico,
            'otros_colaboradores' => $request->otros_colaboradores,
            'sigue_ocurriendo' => $request->sigue_ocurriendo,
            'estado' => $request->estado,
        ]);

        return response()->json([
            'message' => 'Denuncia creada con éxito',
            'denuncia' => $denuncia
        ]);
    }

    // Actualizar una denuncia existente
    public function update(Request $request, Denuncia $denuncia)
    {
        // Validación de datos
        $request->validate($this->rules['update']);

        // Actualizar la denuncia
        $denuncia->update([
            'entidad' => $request->entidad,
            'lugar' => $request->lugar,
            'descripcion' => $request->descripcion,
            'fecha_probable' => $request->fecha_probable,
            'prioridad' => $request->prioridad,
            'tipo_de_hecho' => $request->tipo_de_hecho,
            'monto_economico' => $request->monto_economico,
            'otros_colaboradores' => $request->otros_colaboradores,
            'sigue_ocurriendo' => $request->sigue_ocurriendo,
            'estado' => $request->estado,
        ]);

        return response()->json([
            'message' => 'Denuncia actualizada con éxito',
            'denuncia' => $denuncia
        ]);
    }

    // Eliminar una denuncia
    public function destroy(Denuncia $denuncia)
    {
        // Eliminar la denuncia
        $denuncia->delete();

        return response()->json(['message' => 'Denuncia eliminada con éxito']);
    }

    // Obtener las denuncias en formato JSON
    public function getDenuncias()
    {
        return Denuncia::with('usuario') // Cargar la relación con el usuario
            ->orderBy('created_at', 'desc')
            ->get();
    }

    // Exportar denuncias a Excel o CSV
    public function export()
    {
        return Excel::download(new DenunciasExport, 'denuncias.xlsx');
    }

    // Importar denuncias desde un archivo
    public function import(Request $request)
    {
        try {
            // Validación de archivo
            $request->validate([
                'file' => 'required|mimes:xlsx,csv',
            ]);

            // Importar las denuncias desde el archivo
            Excel::import(new DenunciasImport, $request->file('file'));

            return response()->json(['success' => true, 'message' => 'Denuncias importadas correctamente.']);
        } catch (\Exception $e) {
            Log::error('Error al importar denuncias: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al importar denuncias.'], 500);
        }
    }
}
