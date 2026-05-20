<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Socio;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SocioInstructorController extends Controller
{
    public function index(Request $request)
    {
        $query = Socio::with('user');

        // BUSCADOR (por nombre, apellidos o DNI)
        if ($request->filled('buscar')) {
            $query->where(function ($q) use ($request) {
                $q->where('dni', 'like', "%{$request->buscar}%")
                    ->orWhereHas('user', function ($u) use ($request) {
                        $u->where('nombre', 'like', "%{$request->buscar}%")
                            ->orWhere('apellidos', 'like', "%{$request->buscar}%");
                    });
            });
        }

        // FILTRO ESTADO
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        // FILTRO CANCELADO
        if ($request->filled('cancelado')) {
            $query->where('cancelado', $request->cancelado);
        }

        $socios = $query->latest()->paginate(10);

        return view('panel.instructor.socios', compact('socios'));
    }

    public function store(Request $request)
    {
        // Comprobación de que el DNI no exista ya en BBDD (único en socios)
        $existeDni = Socio::where('dni', $request->dni)->exists();
        if ($existeDni) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Ya existe un socio con ese DNI');
        }

        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'telefono' => 'nullable|string|max:20',
            'dni' => 'required|string|unique:socios,dni',
            'fecha_alta' => 'required|date',
        ]);

        // 1. Crear usuario
        $user = User::create([
            'nombre' => $request->nombre,
            'apellidos' => $request->apellidos,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'password' => Hash::make('temporal123'),
            'rol' => 'usuario'
        ]);

        // 2. Crear socio
        Socio::create([
            'user_id' => $user->id,
            'dni' => $request->dni,
            'cuota' => 10,
            'fecha_alta' => $request->fecha_alta,
            'estado' => 'activo',
            'cancelado' => false,
        ]);

        return redirect()->back()->with('success', 'Socio creado correctamente');
    }

    public function update(Request $request, int $id)
    {
        $socio = Socio::with('user')->findOrFail($id);

        // Comprobación de que el DNI no exista ya en BBDD (sin contar al socio que se está editando)
        $existeDni = Socio::where('dni', $request->dni)->where('id', '!=', $socio->id)->exists();
        if ($existeDni) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Ya existe un socio con ese DNI');
        }

        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'dni' => 'required|string|unique:socios,dni,' . $socio->id,
            'estado' => 'required|in:activo,inactivo',
            'cancelado' => 'required|boolean',
        ]);

        // Actualizar USER
        $socio->user->update([
            'nombre' => $request->nombre,
            'apellidos' => $request->apellidos,
        ]);

        // Actualizar SOCIO
        $socio->update([
            'dni' => $request->dni,
            'estado' => $request->estado,
            'cancelado' => $request->cancelado,
        ]);

        return redirect()->back()->with('success', 'Socio actualizado correctamente');
    }

    public function destroy(int $id)
    {
        $socio = Socio::findOrFail($id);

        $socio->user->update([
            'rol' => 'usuario' // o lo que uses
        ]);

        $socio->delete();

        return redirect()->back()->with('success', 'Socio eliminado correctamente');
    }
}
