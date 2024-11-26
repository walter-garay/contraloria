<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;

class UsuarioController extends Controller
{
    // Reglas de validación separadas
    private $rules = [
        'store' => [
            'name' => 'required|max:255',
            'email' => 'nullable|email|max:255|unique:users,email',
            'password' => 'required|min:6',
            'rol' => 'required|in:Ciudadano,Auditor,Administrador',
            'is_active' => 'boolean',
            'celular' => 'nullable|max:15',
            'dni' => 'nullable|max:15',
            'cargo' => 'nullable|max:255',
        ],
        'update' => [
            'name' => 'required|max:255',
            'email' => 'nullable|email|max:255|unique:users,email',
            'rol' => 'required|in:Ciudadano,Auditor,Administrador',
            'is_active' => 'boolean',
            'celular' => 'nullable|max:15',
            'dni' => 'nullable|max:15',
            'cargo' => 'nullable|max:255',
        ],
    ];

    // Listar usuarios
    public function index()
    {
        $usuarios = User::select('id', 'name', 'email', 'rol', 'is_active', 'celular', 'dni', 'cargo', 'updated_at')
            ->orderBy('id', 'desc')
            ->get();

        return Inertia::render('Usuarios/Index', [
            'usuarios' => $usuarios,
        ]);
    }

    // Crear un usuario
    public function store(Request $request)
    {
        $request->validate($this->rules['store']);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol' => $request->rol,
            'is_active' => $request->is_active ?? true,
            'celular' => $request->celular,
            'dni' => $request->dni,
            'cargo' => $request->cargo,
        ]);

        return response()->json(['success' => true, 'message' => 'Usuario creado exitosamente.']);
    }

    // Actualizar un usuario
    public function update(Request $request, User $usuario)
    {
        $rules = $this->rules['update'];
        // Validar que el email sea único excepto para el usuario actual
        $rules['email'] .= ',' . $usuario->id;

        $request->validate($rules);

        $usuario->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $usuario->password,
            'rol' => $request->rol,
            'is_active' => $request->is_active,
            'celular' => $request->celular,
            'dni' => $request->dni,
            'cargo' => $request->cargo,
        ]);

        return response()->json(['success' => true, 'message' => 'Usuario actualizado exitosamente.']);
    }

    // Eliminar un usuario
    public function destroy(User $usuario)
    {
        $usuario->delete();

        return response()->json(['success' => true, 'message' => 'Usuario eliminado exitosamente.']);
    }

    // Devuelve la lista de usuarios en JSON
    public function getUsuarios()
    {
        return User::select('id', 'name', 'email', 'rol', 'is_active', 'celular', 'dni', 'cargo')
            ->orderBy('name')
            ->get();
    }

    // Exportar usuarios a CSV
    public function export()
    {
        $usuarios = User::all();
        $csvExporter = new \Laracsv\Export();
        $csvExporter->build($usuarios, ['name', 'email', 'rol', 'is_active', 'celular', 'dni', 'cargo', 'created_at'])->download();
    }

    // Importar usuarios desde CSV
    public function import(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|mimes:csv,txt',
            ]);

            Excel::import(new UsersImport, $request->file('file'));

            return response()->json(['success' => true, 'message' => 'Usuarios importados correctamente.']);
        } catch (\Exception $e) {
            Log::error('Error al importar usuarios: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error al importar usuarios.'], 500);
        }
    }
}
