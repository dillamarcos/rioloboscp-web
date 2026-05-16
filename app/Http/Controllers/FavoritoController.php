<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Favorito;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoritoController extends Controller
{

    // Añadir o quitar favorito (TOGGLE)
    public function toggle(int $productoId)
    {
        $user = Auth::user();

        $favorito = Favorito::where('user_id', $user->id)
            ->where('producto_id', $productoId)
            ->first();

        if ($favorito) {
            $favorito->delete();
        } else {
            Favorito::create([
                'user_id' => $user->id,
                'producto_id' => $productoId
            ]);
        }

        return back();
    }

    // Vista favoritos
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $favoritos = $user->favoritos()->get();

        return view('tienda.favoritos', compact('favoritos'));
    }
}
