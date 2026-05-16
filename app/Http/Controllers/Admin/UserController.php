<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('buscar')) {
            $query->where('nombre', 'like', '%' . $request->buscar . '%');
        }

        if ($request->filled('rol')) {
            $query->where('rol', $request->rol);
        }

        $usuarios = $query->latest()->paginate(10);

        return view('panel.admin.usuarios', compact('usuarios'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telefono' => 'nullable|string|max:20',
            'rol' => 'required|in:admin,editor,usuario',
        ]);

        $user->update($request->all());

        return redirect()->back()->with('success', 'Usuario actualizado correctamente');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->back()->with('success', 'Usuario eliminado correctamente');
    }
}
