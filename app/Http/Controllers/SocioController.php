<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Socio;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SocioController extends Controller
{
    public function store(Request $request)
    {
        // VALIDACIÓN BASE
        $rules = [
            'dni' => ['required', 'string', 'max:20', 'unique:socios,dni', 'regex:/^[0-9]{8}[A-Za-z]$/'],
            'telefono' => [
                'nullable',
                'regex:/^[0-9]{9}$/'
            ],
        ];

        // SI NO ESTÁ LOGUEADO → validar usuario
        if (!Auth::check()) {
            $rules = array_merge($rules, [
                'nombre' => ['required', 'string', 'max:255'],
                'apellidos' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255', 'unique:users,email'],
                'password' => ['required', 'min:6'],
            ]);
        }

        $request->validate($rules);

        try {

            // USUARIO
            if (Auth::check()) {

            /** @var \App\Models\User $user */
                $user = Auth::user();

                if ($user->socio) {
                    return back()->with('error', 'Ya eres socio');
                }

                if ($request->filled('telefono')) {
                    $user->telefono = $request->telefono;
                    $user->save();
                }
            } else {

                // CREAR USUARIO NUEVO
                $user = User::create([
                    'nombre' => $request->nombre,
                    'apellidos' => $request->apellidos,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'telefono' => $request->telefono, // 👈 AÑADIDO
                ]);

                Auth::login($user);
            }

            // CREAR SOCIO
            Socio::create([
                'user_id' => $user->id,
                'dni' => $request->dni,
                'fecha_alta' => now(),
                'estado' => 'activo',
            ]);

            return redirect()
                ->route('socio.show')
                ->with('success', 'Te has dado de alta como socio correctamente');
        } catch (\Exception $e) {
            return back()->with('error', 'No se pudo completar el proceso');
        }
    }

    public function show(Request $request)
    {
        $user = $request->user()->load('socio');

        $socio = $user->socio;

        // CONTROL AUTOMÁTICO DE EXPIRACIÓN
        if ($socio && $socio->cancelado && $socio->fecha_fin && now()->gt($socio->fecha_fin)) {
            $socio->update(['estado' => 'inactivo']);
        }

        return view('socio.show', compact('user'));
    }

    public function cancelar()
    {
        try {
            $socio = Auth::user()->socio;

            if (!$socio) {
                return back()->with('error', 'No tienes una suscripción activa');
            }

            $socio->cancelado = true;
            $socio->save();

            return back()->with('success', 'Has cancelado la renovación automática');
        } catch (\Exception $e) {
            return back()->with('error', 'No se pudo cancelar la suscripción');
        }
    }

    public function reactivar()
    {
        try {
            $socio = Auth::user()->socio;

            if (!$socio) {
                return back()->with('error', 'No tienes una suscripción');
            }

            $socio->cancelado = false;
            $socio->save();

            return back()->with('success', 'Suscripción reactivada correctamente');
        } catch (\Exception $e) {
            return back()->with('error', 'No se pudo reactivar la suscripción');
        }
    }

    public function create()
    {
        $user = Auth::user(); // puede ser null

        return view('socio.create', compact('user'));
    }

    public function index()
    {
        return view('socio.index');
    }
}
