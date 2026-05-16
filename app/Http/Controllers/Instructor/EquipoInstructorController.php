<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Equipo;
use App\Models\Temporada;
use Illuminate\Http\Request;

class EquipoInstructorController extends Controller
{
    public function index(Request $request)
    {
        $temporadas = Temporada::all();
        $temporadaActiva = Temporada::where('activa', true)->first();

        // 🔹 temporada seleccionada (filtro o activa)
        $temporadaSeleccionada = $request->filled('temporada_id')
            ? Temporada::find($request->temporada_id)
            : $temporadaActiva;

        // 🔹 base query de equipos
        $query = Equipo::query()
            ->with(['temporadas' => function ($q) use ($temporadaSeleccionada) {
                if ($temporadaSeleccionada) {
                    $q->where('temporada_id', $temporadaSeleccionada->id);
                }
            }]);

        // 🔹 FILTRO POR TEMPORADA (CLAVE)
        if ($temporadaSeleccionada) {
            $query->whereHas('temporadas', function ($q) use ($temporadaSeleccionada) {
                $q->where('temporada_id', $temporadaSeleccionada->id);
            });
        }

        // 🔹 BUSCADOR
        if ($request->filled('buscar')) {
            $query->where('nombre', 'like', '%' . $request->buscar . '%');
        }

        $equipos = $query->get();

        $todosEquipos = Equipo::all();

        return view('panel.instructor.equipos', compact(
            'equipos',
            'temporadas',
            'temporadaSeleccionada',
            'temporadaActiva',
            'todosEquipos'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'temporada_id' => 'required|exists:temporadas,id',
            'equipo_id' => 'nullable|exists:equipos,id',

            'nombre' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string|max:255',
            'localizacion' => 'nullable|string|max:255',
            'entrenador' => 'nullable|string|max:255',
            'escudo' => 'nullable|image|max:2048',

            'categoria' => 'nullable|string|max:255',
            'liga' => 'nullable|string|max:255',
            'grupo' => 'nullable|string|max:255',

            'crear_nuevo' => 'nullable|boolean',
        ]);

        $crearNuevo = filter_var($request->crear_nuevo, FILTER_VALIDATE_BOOLEAN);

        if ($crearNuevo && !$request->nombre) {
            return back()->with('error', 'Debes introducir nombre del equipo');
        }

        if (!$crearNuevo && !$request->equipo_id) {
            return back()->with('error', 'Debes seleccionar un equipo');
        }

        // CASO 1: CREAR NUEVO EQUIPO
        if ($crearNuevo) {

            $equipo = Equipo::create([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'localizacion' => $request->localizacion,
                'entrenador' => $request->entrenador,
                'escudo' => $request->hasFile('escudo')
                    ? $request->file('escudo')->store('equipos', 'public')
                    : null,
            ]);
        } else {

            $equipo = Equipo::findOrFail($request->equipo_id);
        }

        // ASIGNAR A TEMPORADA
        $equipo->temporadas()->syncWithoutDetaching([
            $data['temporada_id'] => [
                'categoria' => $data['categoria'],
                'liga' => $data['liga'],
                'grupo' => $data['grupo'],
            ]
        ]);

        return back()->with('success', 'Equipo asignado correctamente');
    }

    public function update(Request $request, Equipo $equipo)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:255',
            'localizacion' => 'nullable|string|max:255',
            'entrenador' => 'nullable|string|max:255',
            'escudo' => 'nullable|image|max:2048',
        ]);

        $equipo->update($data);

        return back()->with('success', 'Equipo actualizado correctamente');
    }

    public function removeFromSeason(int $equipoId, int $temporadaId)
    {
        $equipo = Equipo::findOrFail($equipoId);

        $equipo->temporadas()->detach($temporadaId);

        return back();
    }
}
