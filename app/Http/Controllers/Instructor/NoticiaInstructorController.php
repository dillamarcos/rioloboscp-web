<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Noticia;
use App\Models\Equipo;
use Illuminate\Support\Facades\Auth;

class NoticiaInstructorController extends Controller
{
    public function index(Request $request)
    {
        $equipo = Equipo::where('nombre', 'Riolobos C.P.')->first();

        $query = Noticia::with(['user'])
            ->where('equipo_id', $equipo->id);

        // BUSCAR POR TÍTULO
        if ($request->filled('buscar')) {
            $query->where('titulo', 'like', '%' . $request->buscar . '%');
        }

        // BUSCAR POR AUTOR
        if ($request->filled('autor')) {

            $autor = $request->autor;

            $query->whereHas('user', function ($q) use ($autor) {

                $q->where('nombre', 'like', "%{$autor}%")
                    ->orWhere('apellidos', 'like', "%{$autor}%");
            });
        }

        // ORDEN FECHA
        $orden = $request->orden ?? 'desc';

        $query->orderBy('fecha_publicacion', $orden);

        $noticias = $query->paginate(10);

        return view('panel.instructor.noticias', compact(
            'noticias'
        ));
    }

    public function store(Request $request)
    {
        try {

            $equipo = Equipo::where('nombre', 'Riolobos C.P.')->firstOrFail();

            $request->validate([
                'titulo' => 'required|max:255',
                'contenido' => 'required',
                'fecha_publicacion' => 'required|date',
                'imagen' => 'nullable|image|max:2048',
            ]);

            $imagen = null;

            if ($request->hasFile('imagen')) {
                $imagen = $request->file('imagen')->store('noticias', 'public');
            }

            Noticia::create([
                'titulo' => $request->titulo,
                'contenido' => $request->contenido,
                'fecha_publicacion' => $request->fecha_publicacion,
                'imagen' => $imagen,
                'user_id' => Auth::id(),
                'equipo_id' => $equipo->id,
            ]);

            return back()->with('success', 'Noticia creada correctamente');
        } catch (\Exception $e) {

            return back()->with('error', 'Error al crear la noticia');
        }
    }

    public function update(Request $request, Noticia $noticia)
    {
        try {

            $request->validate([
                'titulo' => 'required|max:255',
                'contenido' => 'required',
                'fecha_publicacion' => 'required|date',
                'imagen' => 'nullable|image|max:5120',
            ]);

            if ($request->hasFile('imagen')) {
                $noticia->imagen = $request->file('imagen')->store('noticias', 'public');
            }

            $noticia->titulo = $request->titulo;
            $noticia->contenido = $request->contenido;
            $noticia->fecha_publicacion = $request->fecha_publicacion;

            $noticia->save();

            return back()->with('success', 'Noticia actualizada correctamente');
        } catch (\Exception $e) {

            return back()->with('error', 'Error al actualizar la noticia');
        }
    }

    public function destroy(Noticia $noticia)
    {
        $noticia->delete();

        return back()->with('success', 'Noticia eliminada correctamente');
    }
}
