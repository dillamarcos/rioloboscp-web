<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Equipo;
use App\Models\Partido;
use App\Models\Temporada;

class ClasificacionController extends Controller
{
    public function index()
    {
        $riolobos = Equipo::where('nombre', 'Riolobos C.P.')->first();

        $temporadas = Temporada::orderBy('fecha_inicio', 'desc')->get();

        $temporadaSeleccionada = request('temporada')
            ?? Temporada::where('activa', true)->value('id');

        $temporadaActiva = Temporada::where('activa', true)->first();

        $ultimoPartido = Partido::with(['equipoLocal', 'equipoVisitante'])
            ->where('temporada_id', $temporadaActiva->id)
            ->where(function ($query) use ($riolobos) {
                $query->where('equipo_local_id', $riolobos->id)
                    ->orWhere('equipo_visitante_id', $riolobos->id);
            })
            ->where('fecha', '<=', now())
            ->orderBy('fecha', 'desc')
            ->first();

        $proximoPartido = Partido::with(['equipoLocal', 'equipoVisitante'])
            ->where('temporada_id', $temporadaActiva->id)
            ->where(function ($query) use ($riolobos) {
                $query->where('equipo_local_id', $riolobos->id)
                    ->orWhere('equipo_visitante_id', $riolobos->id);
            })
            ->where('fecha', '>', now())
            ->orderBy('fecha', 'asc')
            ->first();

        $clasificacion = DB::select("
            SELECT 
                e.id,
                e.nombre,
                e.escudo,

                COUNT(p.id) AS partidos_jugados,

                SUM(
                    CASE 
                        WHEN (p.equipo_local_id = e.id AND p.goles_local > p.goles_visitante)
                            OR (p.equipo_visitante_id = e.id AND p.goles_visitante > p.goles_local)
                        THEN 1 ELSE 0 
                    END
                ) AS victorias,

                SUM(
                    CASE 
                        WHEN p.goles_local = p.goles_visitante
                        THEN 1 ELSE 0 
                    END
                ) AS empates,

                SUM(
                    CASE 
                        WHEN (p.equipo_local_id = e.id AND p.goles_local < p.goles_visitante)
                            OR (p.equipo_visitante_id = e.id AND p.goles_visitante < p.goles_local)
                        THEN 1 ELSE 0 
                    END
                ) AS derrotas,

                SUM(
                    CASE 
                        WHEN p.equipo_local_id = e.id THEN p.goles_local
                        ELSE p.goles_visitante
                    END
                ) AS goles_a_favor,

                SUM(
                    CASE 
                        WHEN p.equipo_local_id = e.id THEN p.goles_visitante
                        ELSE p.goles_local
                    END
                ) AS goles_en_contra,

                (
                    SUM(
                        CASE 
                            WHEN (p.equipo_local_id = e.id AND p.goles_local > p.goles_visitante)
                                OR (p.equipo_visitante_id = e.id AND p.goles_visitante > p.goles_local)
                            THEN 3 ELSE 0 
                        END
                    )
                    +
                    SUM(
                        CASE 
                            WHEN p.goles_local = p.goles_visitante
                            THEN 1 ELSE 0 
                        END
                    )
                ) AS puntos

            FROM equipo_temporada et

            INNER JOIN equipos e 
                ON e.id = et.equipo_id

            LEFT JOIN partidos p 
                ON (
                    e.id = p.equipo_local_id 
                    OR e.id = p.equipo_visitante_id
                )
                AND p.fecha <= NOW()
                AND p.goles_local IS NOT NULL
                AND p.goles_visitante IS NOT NULL
                AND p.temporada_id = ?

            WHERE et.temporada_id = ?

            GROUP BY e.id, e.nombre, e.escudo

            ORDER BY puntos DESC, (goles_a_favor - goles_en_contra) DESC
        ", [
            $temporadaSeleccionada,
            $temporadaSeleccionada
        ]);

        return view('clasificacion.index', compact(
            'clasificacion',
            'ultimoPartido',
            'proximoPartido',
            'riolobos',
            'temporadas',
            'temporadaSeleccionada',
        ));
    }
}
