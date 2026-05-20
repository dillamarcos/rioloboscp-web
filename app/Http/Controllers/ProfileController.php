<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        try {
            $user = $request->user();

            // 1. Llenamos el modelo con los datos validados pero NO guardamos todavía
            $user->fill($request->validated());

            // 2. Comprobamos si hay cambios en los campos de texto O si se ha subido una foto nueva
            $hayFotoNueva = $request->hasFile('foto_perfil');

            if (!$user->isDirty() && !$hayFotoNueva) {
                return redirect()
                    ->route('profile.edit')
                    ->with('info', 'No ha realizado ningún cambio en su perfil.');
            }

            // 3. Si hay foto, la procesamos
            if ($hayFotoNueva) {
                if ($user->foto_perfil) {
                    Storage::disk('public')->delete($user->foto_perfil);
                }
                $path = $request->file('foto_perfil')->store('perfil', 'public');
                $user->foto_perfil = $path;
            }

            // 4. Guardamos los cambios
            $user->save();

            // 5. Manejo de verificación de email si cambió
            if ($user->wasChanged('email')) {
                $user->email_verified_at = null;
                $user->save();
            }

            return redirect()
                ->route('profile.edit')
                ->with('success', 'Perfil actualizado correctamente');
        } catch (\Exception $e) {
            return back()->with('error', 'No se pudo actualizar el perfil');
        }
    }

    public function deletePhoto(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->foto_perfil) {
            // Eliminar archivo físico
            Storage::disk('public')->delete($user->foto_perfil);

            // Actualizar base de datos
            $user->update(['foto_perfil' => null]);

            // CAMBIO: Usamos 'success' para que el Toast lo detecte como un cambio exitoso
            return back()->with('success', 'Foto de perfil eliminada correctamente');
        }

        return back()->with('info', 'No había ninguna foto que eliminar.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
