<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use App\Models\Partido;

class HomeController extends Controller
{
    public function index()
    {
        $equipoId = 1;

        $ultimasNoticias = Noticia::where('equipo_id', $equipoId)
            ->orderBy('fecha_publicacion', 'desc')
            ->take(10)
            ->get();

        $partidos = Partido::with(['equipoLocal', 'equipoVisitante'])
            ->where(function ($q) use ($equipoId) {
                $q->where('equipo_local_id', $equipoId)
                    ->orWhere('equipo_visitante_id', $equipoId);
            })
            ->orderBy('fecha', 'desc')
            ->get();

        // SOLO JUGADOS
        $partidosJugados = $partidos->filter(function ($p) {
            return $p->fecha <= now()
                && !is_null($p->goles_local)
                && !is_null($p->goles_visitante);
        });

        $ultimoPartido = $partidosJugados->first();

        $proximoPartido = $partidos
            ->filter(fn($p) => $p->fecha > now())
            ->last();

        $victorias = 0;
        $empates = 0;
        $derrotas = 0;
        $racha = [];

        foreach ($partidosJugados->take(5) as $partido) {

            $local = $partido->equipo_local_id == $equipoId;
            $golesFavor = $local ? $partido->goles_local : $partido->goles_visitante;
            $golesContra = $local ? $partido->goles_visitante : $partido->goles_local;

            if ($golesFavor > $golesContra) {
                $victorias++;
                $racha[] = 'V';
            } elseif ($golesFavor == $golesContra) {
                $empates++;
                $racha[] = 'E';
            } else {
                $derrotas++;
                $racha[] = 'D';
            }
        }

        $puntos = ($victorias * 3) + $empates;

        $puesto = 1;

        return view('home', compact(
            'ultimasNoticias','ultimoPartido','proximoPartido','racha','victorias','empates',
            'derrotas','puntos','puesto','equipoId'
        ));
    }
}
