<?php

namespace App\Http\Controllers;

use App\Models\Denuncia;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;

class DenunciaController extends Controller
{
    // Reglas de validación separadas
    private $rules = [
        'store' => [
            'user_id' => 'required|exists:users,id',
            'entidad' => 'required|max:255',
            'lugar' => 'required|max:255',
            'descripcion' => 'required',
            'fecha_probable' => 'required|date',
            'prioridad' => 'nullable|integer',
            'tipo_de_hecho' => 'nullable|max:255',
            'monto_economico' => 'nullable|numeric|min:0',
            'otros_colaboradores' => 'nullable',
            'sigue_ocurriendo' => 'nullable|boolean',
            'estado' => 'required|in:En proceso,Admitido,No admitido,Derivado a OCI',
        ],
        'update' => [
            'user_id' => 'required|exists:users,id',
            'entidad' => 'required|max:255',
            'lugar' => 'required|max:255',
            'descripcion' => 'required',
            'fecha_probable' => 'required|date',
            'prioridad' => 'nullable|integer',
            'tipo_de_hecho' => 'nullable|max:255',
            'monto_economico' => 'nullable|numeric|min:0',
            'otros_colaboradores' => 'nullable',
            'sigue_ocurriendo' => 'nullable|boolean',
            'estado' => 'required|in:En proceso,Admitido,No admitido,Derivado a OCI',
        ],
    ];

    // Listar denuncias
    public function index()
    {
        $denuncias = Denuncia::with('usuario:id,name')
            ->select('id', 'user_id', 'entidad', 'lugar', 'descripcion', 'fecha_probable', 'prioridad', 'tipo_de_hecho', 'monto_economico', 'sigue_ocurriendo', 'estado', 'updated_at')
            ->orderBy('id', 'desc')
            ->get();

        return Inertia::render('Denuncias/Index', [
            'denuncias' => $denuncias,
        ]);
    }

    // Crear una denuncia
    public function store(Request $request)
    {
        $request->validate($this->rules['store']);

        Denuncia::create($request->all());

        return response()->json(['success' => true, 'message' => 'Denuncia registrada exitosamente.']);
    }

    // Actualizar una denuncia
    public function update(Request $request, Denuncia $denuncia)
    {
        $request->validate($this->rules['update']);

        $denuncia->update($request->all());

        return response()->json(['success' => true, 'message' => 'Denuncia actualizada exitosamente.']);
    }

    // Eliminar una denuncia
    public function destroy(Denuncia $denuncia)
    {
        $denuncia->delete();

        return response()->json(['success' => true, 'message' => 'Denuncia eliminada exitosamente.']);
    }

    // Devuelve la lista de denuncias en JSON
    public function getDenuncias()
    {
        return Denuncia::with('usuario:id,name')
            ->select('id', 'user_id', 'entidad', 'lugar', 'descripcion', 'fecha_probable', 'prioridad', 'tipo_de_hecho', 'monto_economico', 'sigue_ocurriendo', 'estado', 'updated_at')
            ->orderBy('id', 'desc')
            ->get();
    }

    // Exportar denuncias a CSV
    public function export()
    {
        $denuncias = Denuncia::with('usuario:id,name')->get();
        $csvExporter = new \Laracsv\Export();
        $csvExporter->build($denuncias, ['id', 'user_id', 'entidad', 'lugar', 'descripcion', 'fecha_probable', 'prioridad', 'tipo_de_hecho', 'monto_economico', 'sigue_ocurriendo', 'estado', 'created_at', 'updated_at'])->download();
    }

    // Importar denuncias desde CSV
    public function import(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|mimes:csv,txt',
            ]);

            Excel::import(new DenunciasImport, $request->file('file'));

            return response()->json(['success' => true, 'message' => 'Denuncias importadas correctamente.']);
        } catch (\Exception $e) {
            Log::error('Error al importar denuncias: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al importar denuncias.'], 500);
        }
    }
}
