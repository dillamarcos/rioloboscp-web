<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jugador;
use App\Models\Equipo;

class JugadorInstructorController extends Controller
{
    public function index(Request $request)
    {
        $equipo = Equipo::where('nombre', 'Riolobos C.P.')->firstOrFail();

        $query = Jugador::where('equipo_id', $equipo->id);

        // BUSCAR
        if ($request->filled('buscar')) {

            $query->where(function ($q) use ($request) {

                $q->where('nombre', 'like', '%' . $request->buscar . '%')
                    ->orWhere('apellidos', 'like', '%' . $request->buscar . '%');
            });
        }

        // POSICIÓN
        if ($request->filled('posicion')) {
            $query->where('posicion', $request->posicion);
        }

        // GOLES
        if ($request->filled('goles')) {
            $query->orderBy('goles', $request->goles);
        }

        $jugadores = $query
            ->orderBy('dorsal')
            ->paginate(10);

        return view('panel.instructor.jugadores', compact('jugadores'));
    }

    public function store(Request $request)
    {
        $equipo = Equipo::where('nombre', 'Riolobos C.P.')->firstOrFail();

        $request->validate([
            'nombre' => 'required|max:255',
            'apellidos' => 'nullable|max:255',
            'dorsal' => 'required|integer',
            'posicion' => 'required',
            'fecha_nacimiento' => 'nullable|date',
            'altura' => 'required|numeric',
            'goles' => 'nullable|integer',
            'amarillas' => 'nullable|integer',
            'rojas' => 'nullable|integer',
            'imagen' => 'nullable|image|max:2048',
        ]);

        $imagen = null;

        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen')->store('jugadores', 'public');
        }

        Jugador::create([
            'nombre' => $request->nombre,
            'apellidos' => $request->apellidos,
            'dorsal' => $request->dorsal,
            'posicion' => $request->posicion,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'altura' => (float) str_replace(',', '.', $request->altura),
            'goles' => $request->goles ?? 0,
            'amarillas' => $request->amarillas ?? 0,
            'rojas' => $request->rojas ?? 0,
            'imagen' => $imagen,
            'equipo_id' => $equipo->id,
        ]);

        return back()->with('success', 'Jugador creado correctamente');
    }

    public function update(Request $request, Jugador $jugador)
    {
        $request->validate([
            'nombre' => 'required|max:255',
            'apellidos' => 'nullable|max:255',
            'dorsal' => 'required|integer',
            'posicion' => 'required',
            'fecha_nacimiento' => 'nullable|date',
            'altura' => 'required|numeric',
            'goles' => 'nullable|integer',
            'amarillas' => 'nullable|integer',
            'rojas' => 'nullable|integer',
            'imagen' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('imagen')) {
            $jugador->imagen = $request->file('imagen')->store('jugadores', 'public');
        }

        $jugador->update([
            'nombre' => $request->nombre,
            'apellidos' => $request->apellidos,
            'dorsal' => $request->dorsal,
            'posicion' => $request->posicion,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'altura' => (float) str_replace(',', '.', $request->altura),
            'goles' => $request->goles ?? 0,
            'amarillas' => $request->amarillas ?? 0,
            'rojas' => $request->rojas ?? 0,
        ]);

        return back()->with('success', 'Jugador actualizado correctamente');
    }

    public function destroy(Jugador $jugador)
    {
        $jugador->delete();

        return back()->with('success', 'Jugador eliminado correctamente');
    }
}
