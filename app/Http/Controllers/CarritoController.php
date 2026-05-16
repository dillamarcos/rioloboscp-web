<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Carrito;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\PedidoCarritoMail;

use Illuminate\Support\Facades\Auth;

class CarritoController extends Controller
{
    public function toggle(int $productoId)
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        $item = Carrito::where('user_id', $user->id)
            ->where('producto_id', $productoId)
            ->first();

        if ($item) {
            $item->delete();
        } else {
            Carrito::create([
                'user_id' => $user->id,
                'producto_id' => $productoId,
                'cantidad' => 1
            ]);
        }

        return back();
    }

    public function index()
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        $items = $user->carrito()->with('producto')->get();

        $total = $items->sum(function ($item) {
            return $item->producto->precio * $item->cantidad;
        });

        return view('tienda.carrito', compact('items', 'total'));
    }

    // AUMENTAR CANTIDAD
    public function increase(int $id)
    {
        $item = Carrito::findOrFail($id);

        $item->increment('cantidad');

        return back();
    }

    // DISMINUIR CANTIDAD
    public function decrease(int $id)
    {
        $item = Carrito::findOrFail($id);

        if ($item->cantidad > 1) {
            $item->decrement('cantidad');
        } else {
            $item->delete(); // si llega a 1, lo elimina
        }

        return back();
    }

    // ELIMINAR DIRECTO
    public function remove(int $id)
    {
        Carrito::findOrFail($id)->delete();

        return back();
    }

    public function solicitarCompra()
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        $items = $user->carrito()->with('producto')->get();

        $total = 0;

        foreach ($items as $item) {
            $total += $item->producto->precio * $item->cantidad;
        }

        $esSocio = $user->socio ?? false;
        $descuento = $esSocio ? $total * 0.05 : 0;
        $totalFinal = $total - $descuento;

        // ENVIAR EMAIL
        Mail::to('rioloboscp@gmail.com') 
            ->send(new PedidoCarritoMail(
                $user,
                $items,
                $total,
                $descuento,
                $totalFinal
            ));

        // vaciar carrito
        $user->carrito()->delete();

        return redirect()->route('carrito.index')
            ->with('success', 'Pedido enviado correctamente');
    }
}
