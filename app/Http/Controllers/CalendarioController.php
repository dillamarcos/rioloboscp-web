<?php

namespace App\Http\Controllers;

use App\Models\Partido;
use App\Models\Equipo;
use App\Models\Temporada;
use Illuminate\Http\Request;

class CalendarioController extends Controller
{
    public function index(Request $request)
    {
        $equipo = Equipo::where('nombre', 'Riolobos C.P.')->firstOrFail();

        // TEMPORADAS
        $temporadas = Temporada::orderBy('fecha_inicio', 'desc')->get();

        // TEMPORADA ACTIVA
        $temporadaActiva = Temporada::where('activa', true)->first();

        // TEMPORADA SELECCIONADA
        $temporadaSeleccionada = $request->filled('temporada')
            ? Temporada::find($request->temporada)
            : $temporadaActiva;

        $partidos = Partido::with(['equipoLocal', 'equipoVisitante'])

            ->where(function ($q) use ($equipo) {
                $q->where('equipo_local_id', $equipo->id)
                    ->orWhere('equipo_visitante_id', $equipo->id);
            })

            // FILTRO TEMPORADA
            ->when($temporadaSeleccionada, function ($q) use ($temporadaSeleccionada) {
                $q->where('temporada_id', $temporadaSeleccionada->id);
            })

            ->orderBy('fecha', 'asc')
            ->get();

        return view('calendario.index', [
            'partidos' => $partidos,
            'equipoId' => $equipo->id,
            'temporadas' => $temporadas,
            'temporadaSeleccionada' => $temporadaSeleccionada,
        ]);
    }
}
