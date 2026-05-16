<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\ContactoMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactoController extends Controller
{
    public function enviarEmail(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'mensaje' => 'required|string|max:1000',
                'asunto' => 'required|string|max:255',
            ]);

            Mail::to('rioloboscp@gmail.com')->send(
                new ContactoMail([
                    'email' => $request->email,
                    'mensaje' => $request->mensaje,
                    'asunto' => $request->asunto
                ])
            );

            return back()->with('success', 'Mensaje enviado correctamente');
        } catch (\Exception $e) {
            return back()->with('error', 'No se pudo enviar el mensaje. Inténtalo más tarde');
        }
    }

    public function enviarWhatsapp(Request $request)
    {
        $request->validate([
            'telefono' => 'required|string',
            'mensaje' => 'required|string|min:5|max:1000',
        ]);

        // limpiar número (quita espacios, +, etc.)
        $telefono = preg_replace('/[^0-9]/', '', $request->telefono);

        // mensaje preparado
        $mensaje = urlencode($request->mensaje);

        // URL de WhatsApp
        $url = "https://wa.me/34{$telefono}?text={$mensaje}";

        return redirect($url);
    }
}
