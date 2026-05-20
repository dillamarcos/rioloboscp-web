<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Temporada;
use Illuminate\Http\Request;

class TemporadaInstructorController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => [
                'required',
                'string',
                'size:7',
                'regex:/^\d{4}\/\d{2}$/',
                'unique:temporadas,nombre',
            ],
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'activa' => 'nullable|boolean',
        ], [
            'nombre.unique' => 'Ya existe una temporada con ese nombre.',
            'nombre.size' => 'El formato debe ser 2025/26 (7 caracteres).',
            'nombre.regex' => 'El formato debe ser YYYY/YY (ej: 2025/26).',
        ]);

        if ($request->has('activa')) {
            Temporada::where('activa', true)->update([
                'activa' => false
            ]);
        }

        // desactivar otras si esta es activa
        if (!empty($data['activa'])) {
            Temporada::where('activa', true)->update(['activa' => false]);
        }

        Temporada::create([
            'nombre' => $data['nombre'],
            'fecha_inicio' => $data['fecha_inicio'],
            'fecha_fin' => $data['fecha_fin'],
            'activa' => $request->has('activa'),
        ]);

        return back()->with('success', 'Temporada creada correctamente');
    }

    public function update(Request $request, Temporada $temporada)
    {
        $data = $request->validate([
            'nombre' => [
                'required',
                'string',
                'size:7',
                'regex:/^\d{4}\/\d{2}$/',
                'unique:temporadas,nombre,' . $temporada->id,
            ],
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        $data['activa'] = $request->has('activa');

        if ($data['activa']) {
            Temporada::where('id', '!=', $temporada->id)
                ->where('activa', true)
                ->update(['activa' => false]);
        }

        $temporada->update($data);

        return back()->with('success', 'Temporada actualizada correctamente');
    }

    public function destroy(Temporada $temporada)
    {
        $temporada->delete();

        return back()->with('success', 'Temporada eliminada correctamente');
    }
}
