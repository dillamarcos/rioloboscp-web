<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SolicitudSocio;
use App\Models\User;
use App\Notifications\NuevaSolicitudSocio;
use App\Models\Socio;

class SolicitudSocioController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'telefono' => ['nullable', 'regex:/^[0-9]{9}$/'],
            'dni' => ['required', 'regex:/^[0-9]{8}[A-Za-z]$/'],
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Evitar duplicados
        if ($user->solicitudes()->where('estado', 'pendiente')->exists()) {
            return back()->with('info', 'Ya tienes una solicitud pendiente');
        }

        // Crear solicitud
        $solicitud = SolicitudSocio::create([
            'user_id' => $user->id,
            'dni' => $request->dni,
            'telefono' => $request->telefono,
            'estado' => 'pendiente',
        ]);

        /** @var \Illuminate\Database\Eloquent\Collection<\App\Models\User> $admins */
        $admins = User::where('rol', 'admin')->get();

        foreach ($admins as $admin) {
            $admin->notify(new NuevaSolicitudSocio($solicitud));
        }

        return redirect()
            ->route('socio.index')
            ->with('success', 'Solicitud enviada correctamente');
    }

    public function index(Request $request)
    {
        $query = SolicitudSocio::with('user');

        // BUSCADOR
        if ($request->filled('buscar')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('nombre', 'like', "%{$request->buscar}%")
                    ->orWhere('apellidos', 'like', "%{$request->buscar}%")
                    ->orWhere('email', 'like', "%{$request->buscar}%");
            })->orWhere('dni', 'like', "%{$request->buscar}%");
        }

        // FILTRO ESTADO
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $solicitudes = $query->latest()->get();

        return view('panel.instructor.solicitudes', compact('solicitudes'));
    }

    public function aceptar(int $id)
    {
        $solicitud = SolicitudSocio::findOrFail($id);

        // evitar duplicados
        if ($solicitud->user->socio) {
            return back()->with('error', 'Este usuario ya es socio');
        }

        Socio::create([
            'user_id' => $solicitud->user_id,
            'dni' => $solicitud->dni,
            'fecha_alta' => now(),
            'estado' => 'activo',
        ]);

        $solicitud->estado = 'aceptada';
        $solicitud->save();

        return back()->with('success', 'Solicitud aceptada');
    }

    public function rechazar(int $id)
    {
        $solicitud = SolicitudSocio::findOrFail($id);

        $solicitud->estado = 'rechazada';
        $solicitud->save();

        return back()->with('success', 'Solicitud rechazada');
    }
}
