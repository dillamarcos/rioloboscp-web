<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Equipo;
use App\Models\Jugador;
use App\Models\Partido;
use Carbon\Carbon;

class EquipoController extends Controller
{
    public function index()
    {
        $equipo = Equipo::where('nombre', 'Riolobos C.P.')->first();

        $jugadores = Jugador::where('equipo_id', $equipo->id)
            ->orderBy('dorsal', 'asc')
            ->get();

        // GOLEADORES
        $topGoleadores = Jugador::orderBy('goles', 'desc')
            ->take(5)
            ->get()
            ->values();

        $pichichi = $topGoleadores->first();

        // PARTIDOS
        $partidos = Partido::where(function ($q) use ($equipo) {
            $q->where('equipo_local_id', $equipo->id)
                ->orWhere('equipo_visitante_id', $equipo->id);
        })
            ->whereNotNull('goles_local')
            ->whereNotNull('goles_visitante')
            ->where('fecha', '<', now())
            ->orderBy('fecha', 'asc') // importante para racha
            ->get();

        $victorias = 0;
        $empates = 0;
        $derrotas = 0;

        $golesPorMes = array_fill(1, 12, 0);

        $golesFavor = 0;
        $golesContra = 0;

        $golesCasa = 0;
        $golesFuera = 0;
        $golesContraCasa = 0;
        $golesContraFuera = 0;

        $racha = [];

        // LOOP PARTIDOS
        foreach ($partidos as $partido) {

            $esLocal = $partido->equipo_local_id == $equipo->id;

            $gf = $esLocal ? $partido->goles_local : $partido->goles_visitante;
            $gc = $esLocal ? $partido->goles_visitante : $partido->goles_local;

            // RESULTADOS
            if ($gf > $gc) {
                $victorias++;
                $resultado = 'V';
            } elseif ($gf == $gc) {
                $empates++;
                $resultado = 'E';
            } else {
                $derrotas++;
                $resultado = 'D';
            }

            // GOLES TOTALES
            $golesFavor += $gf;
            $golesContra += $gc;

            // CASA / FUERA
            if ($esLocal) {
                $golesCasa += $gf;
                $golesContraCasa += $gc;
            } else {
                $golesFuera += $gf;
                $golesContraFuera += $gc;
            }

            // GOLES POR MES
            $mes = Carbon::parse($partido->fecha)->month;
            $golesPorMes[$mes] += $gf;

            // RACHA (guardamos todos y luego recortamos)
            $racha[] = $resultado;
        }

        // POST PROCESADO
        $partidosJugados = $partidos->count();

        // Últimos 5 partidos
        $racha = array_slice(array_reverse($racha), 0, 5);

        // TARJETAS 
        $amarillas = Jugador::where('equipo_id', $equipo->id)->sum('amarillas');
        $rojas = Jugador::where('equipo_id', $equipo->id)->sum('rojas');

        return view('equipo.index', compact(
            'equipo',
            'jugadores',
            'topGoleadores',
            'pichichi',
            'victorias',
            'empates',
            'derrotas',
            'golesPorMes',

            // NUEVAS
            'partidosJugados',
            'golesFavor',
            'golesContra',
            'golesCasa',
            'golesFuera',
            'golesContraCasa',
            'golesContraFuera',
            'racha',
            'amarillas',
            'rojas'
        ));
    }
}
