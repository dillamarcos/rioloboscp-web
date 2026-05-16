<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PedidoCarritoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $items;
    public $total;
    public $descuento;
    public $totalFinal;

    public function __construct($user, $items, $total, $descuento, $totalFinal)
    {
        $this->user = $user;
        $this->items = $items;
        $this->total = $total;
        $this->descuento = $descuento;
        $this->totalFinal = $totalFinal;
    }

    public function build()
    {
        return $this->subject('Nueva solicitud de compra - Riolobos CP')
            ->view('emails.pedido-carrito');
    }
}
