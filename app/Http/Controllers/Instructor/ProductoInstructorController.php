<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Equipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductoInstructorController extends Controller
{
    public function index(Request $request)
    {
        $query = Producto::with(['categoria', 'equipo']);

        // BUSCADOR
        if ($request->filled('buscar')) {
            $query->where('nombre', 'like', "%{$request->buscar}%");
        }

        // FILTRO CATEGORÍA
        if ($request->filled('categoria')) {
            $query->where('categoria_id', $request->categoria);
        }

        // FILTRO ACTIVO
        if ($request->filled('activo')) {
            $query->where('activo', $request->activo);
        }

        $productos = $query->latest()->paginate(10);
        $categorias = Categoria::all();

        return view('panel.instructor.productos', compact('productos', 'categorias'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion_corta' => 'required|string',
            'descripcion_larga' => 'required|string',
            'precio' => 'required|numeric|min:0',
            'imagen' => 'nullable|image|max:2048',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        $equipo = Equipo::where('nombre', 'Riolobos C.P.')->firstOrFail();
        $data['equipo_id'] = $equipo->id;

        // IMAGEN
        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        Producto::create($data);

        return back()->with('success', 'Producto creado correctamente');
    }

    public function update(Request $request, Producto $producto)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion_corta' => 'required|string',
            'descripcion_larga' => 'required|string',
            'precio' => 'required|numeric|min:0',
            'imagen' => 'nullable|image|max:2048',
            'activo' => 'required|boolean',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        $equipo = Equipo::where('nombre', 'Riolobos C.P.')->firstOrFail();
        $data['equipo_id'] = $equipo->id;

        // IMAGEN NUEVA
        if ($request->hasFile('imagen')) {

            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }

            $data['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        $producto->update($data);

        return back()->with('success', 'Producto actualizado correctamente');
    }

    public function destroy(Producto $producto)
    {
        if ($producto->imagen) {
            Storage::disk('public')->delete($producto->imagen);
        }

        $producto->delete();

        return back()->with('success', 'Producto eliminado correctamente');
    }
}
