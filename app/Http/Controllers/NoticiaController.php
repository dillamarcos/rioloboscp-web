<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Noticia;
use Illuminate\Http\Request;

class NoticiaController extends Controller
{
    public function index()
    {
        $ultimaNoticia = Noticia::with('user')
            ->latest('fecha_publicacion')
            ->first();

        $noticias = Noticia::where('id', '!=', $ultimaNoticia?->id)
            ->latest('fecha_publicacion')
            ->paginate(8);

        return view('noticias.index', compact('ultimaNoticia', 'noticias'));
    }

    public function show($id)
    {
        $noticia = Noticia::with('user')->findOrFail($id);

        return view('noticias.show', compact('noticia'));
    }
}
