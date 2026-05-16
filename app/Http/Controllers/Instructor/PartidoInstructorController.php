<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Partido;
use App\Models\Equipo;
use App\Models\Temporada;
use Carbon\Carbon;

class PartidoInstructorController extends Controller
{
    public function index(Request $request)
    {

        $temporadaActiva = Temporada::where('activa', true)->first();

        $query = Partido::with([
            'equipoLocal',
            'equipoVisitante'
        ]);

        // BUSCADOR
        if ($request->filled('buscar')) {

            $query->where(function ($q) use ($request) {

                $q->whereHas('equipoLocal', function ($sub) use ($request) {

                    $sub->where('nombre', 'like', '%' . $request->buscar . '%');
                })->orWhereHas('equipoVisitante', function ($sub) use ($request) {

                    $sub->where('nombre', 'like', '%' . $request->buscar . '%');
                });
            });
        }

        if ($request->temporada) {
            $query->where('temporada_id', $request->temporada);
        }

        // FILTRO JORNADA
        if ($request->filled('jornada')) {

            $query->where('jornada', $request->jornada);
        }

        // FILTRO EQUIPO
        if ($request->filled('equipo')) {

            $query->where(function ($q) use ($request) {

                $q->where('equipo_local_id', $request->equipo)
                    ->orWhere('equipo_visitante_id', $request->equipo);
            });
        }

        $partidos = $query
            ->orderBy('jornada')
            ->orderBy('fecha')
            ->paginate(10);

        // EQUIPOS
        $equipos = Equipo::orderBy('nombre')->get();

        // TEMPORADAS
        $temporadas = Temporada::with('equipos')->orderBy('fecha_inicio', 'desc')->get();

        // JORNADAS
        $jornadas = Partido::select('jornada')
            ->distinct()
            ->orderBy('jornada')
            ->pluck('jornada');

        return view('panel.instructor.partidos', compact(
            'partidos',
            'equipos',
            'temporadas',
            'temporadaActiva',
            'jornadas'
        ));
    }

    public function store(Request $request)
    {
        try {

            $validated = $request->validate([
                'equipo_local_id' => 'required|exists:equipos,id',
                'equipo_visitante_id' => 'required|exists:equipos,id|different:equipo_local_id',
                'fecha' => 'required|date',
                'jornada' => 'required|integer|min:1',
                'goles_local' => 'nullable|integer|min:0',
                'goles_visitante' => 'nullable|integer|min:0',
                'campo' => 'nullable|string|max:255',
                'temporada_id' => 'required|exists:temporadas,id',
            ]);

            $fecha = Carbon::parse($validated['fecha']);

            if ($fecha->isFuture() && (
                !is_null($validated['goles_local']) || !is_null($validated['goles_visitante'])
            )) {
                return back()
                    ->withInput()
                    ->with('error', 'No puedes asignar resultado a un partido que aún no se ha jugado.');
            }

            if ($validated['equipo_local_id'] == $validated['equipo_visitante_id']) {

                return back()
                    ->withInput()
                    ->with('error', 'Un equipo no puede jugar contra sí mismo.');
            }

            // COMPROBAR SI ALGÚN EQUIPO YA JUEGA ESA JORNADA
            $existePartido = Partido::where('jornada', $validated['jornada'])
                ->where('temporada_id', $validated['temporada_id'])
                ->where(function ($q) use ($validated) {

                    $q->where('equipo_local_id', $validated['equipo_local_id'])
                        ->orWhere('equipo_visitante_id', $validated['equipo_local_id'])
                        ->orWhere('equipo_local_id', $validated['equipo_visitante_id'])
                        ->orWhere('equipo_visitante_id', $validated['equipo_visitante_id']);
                })
                ->exists();

            if ($existePartido) {

                return back()
                    ->withInput()
                    ->with('error', 'Uno de los equipos ya tiene un partido en esta jornada.');
            }

            Partido::create([
                'equipo_local_id' => $validated['equipo_local_id'],
                'equipo_visitante_id' => $validated['equipo_visitante_id'],
                'fecha' => $validated['fecha'],
                'jornada' => $validated['jornada'],
                'goles_local' => $validated['goles_local'] ?? 0,
                'goles_visitante' => $validated['goles_visitante'] ?? 0,
                'campo' => $validated['campo'] ?? null,
                'temporada_id' => $validated['temporada_id'],
            ]);

            return back()->with('success', 'Partido creado correctamente');
        } catch (\Exception $e) {

            return back()
                ->withInput()
                ->with('error', 'Error al crear el partido');
        }
    }

    public function update(Request $request, Partido $partido)
    {
        try {

            $validated = $request->validate([
                'equipo_local_id' => 'required|exists:equipos,id',
                'equipo_visitante_id' => 'required|exists:equipos,id|different:equipo_local_id',
                'fecha' => 'required|date',
                'jornada' => 'required|integer|min:1',
                'goles_local' => 'nullable|integer|min:0',
                'goles_visitante' => 'nullable|integer|min:0',
                'campo' => 'nullable|string|max:255',
                'temporada_id' => 'required|exists:temporadas,id',
            ]);

            $fecha = Carbon::parse($validated['fecha']);

            if ($fecha->isFuture() && (
                !is_null($validated['goles_local']) || !is_null($validated['goles_visitante'])
            )) {
                return back()
                    ->withInput()
                    ->with('error', 'No puedes asignar resultado a un partido futuro.');
            }

            if ($validated['equipo_local_id'] == $validated['equipo_visitante_id']) {

                return back()
                    ->withInput()
                    ->with('error', 'Un equipo no puede jugar contra sí mismo.');
            }

            // COMPROBAR SI ALGÚN EQUIPO YA JUEGA ESA JORNADA
            $existePartido = Partido::where('jornada', $validated['jornada'])
                ->where('temporada_id', $validated['temporada_id'])
                ->where('id', '!=', $partido->id)
                ->where(function ($q) use ($validated) {

                    $q->where('equipo_local_id', $validated['equipo_local_id'])
                        ->orWhere('equipo_visitante_id', $validated['equipo_local_id'])
                        ->orWhere('equipo_local_id', $validated['equipo_visitante_id'])
                        ->orWhere('equipo_visitante_id', $validated['equipo_visitante_id']);
                })
                ->exists();

            if ($existePartido) {

                return back()
                    ->withInput()
                    ->with('error', 'Uno de los equipos ya tiene un partido en esta jornada.');
            }

            $partido->update([
                'equipo_local_id' => $validated['equipo_local_id'],
                'equipo_visitante_id' => $validated['equipo_visitante_id'],
                'fecha' => $validated['fecha'],
                'jornada' => $validated['jornada'],
                'goles_local' => $validated['goles_local'] ?? 0,
                'goles_visitante' => $validated['goles_visitante'] ?? 0,
                'campo' => $validated['campo'] ?? null,
                'temporada_id' => $validated['temporada_id'],
            ]);

            return back()->with('success', 'Partido actualizado correctamente');
        } catch (\Exception $e) {

            return back()
                ->withInput()
                ->with('error', 'Error al actualizar el partido');
        }
    }

    public function destroy(Partido $partido)
    {
        try {

            $partido->delete();

            return back()->with('success', 'Partido eliminado correctamente');
        } catch (\Exception $e) {

            return back()->with('error', 'Error al eliminar el partido');
        }
    }
}
