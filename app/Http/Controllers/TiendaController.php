<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\Carrito;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Categoria;

class TiendaController extends Controller
{
    public function index(Request $request)
    {
        $query = Producto::where('activo', true);

        // BUSCADOR
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->search . '%')
                    ->orWhere('descripcion_corta', 'like', '%' . $request->search . '%');
            });
        }

        // PRECIO MIN
        if ($request->filled('precio_min')) {
            $query->where('precio', '>=', $request->precio_min);
        }

        // PRECIO MAX
        if ($request->filled('precio_max')) {
            $query->where('precio', '<=', $request->precio_max);
        }

        // CATEGORÍA
        if ($request->filled('categoria')) {
            $query->where('categoria_id', $request->categoria);
        }

        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        return view('tienda.index', [
            // PRODUCTOS
            'productos' => $query->latest()->paginate(9)->withQueryString(),

            // CATEGORÍAS
            'categorias' => Categoria::all(),

            // CONTADORES
            'favoritosCount' => Auth::check()
                ? $user->favoritos()->count()
                : 0,

            'carritoCount' => Auth::check()
                ? Carrito::where('user_id', Auth::id())->sum('cantidad')
                : 0,
        ]);
    }

    public function show(Producto $producto)
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        return view('tienda.show', [
            'producto' => $producto,
            'favoritosCount' => Auth::check()
                ? $user->favoritos()->count()
                : 0,

            'carritoCount' => Auth::check()
                ? Carrito::where('user_id', Auth::id())->sum('cantidad')
                : 0,
        ]);
    }
}
