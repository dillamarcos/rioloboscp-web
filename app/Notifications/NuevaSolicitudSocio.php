<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NuevaSolicitudSocio extends Notification
{
    public $solicitud;

    public function __construct($solicitud)
    {
        $this->solicitud = $solicitud;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Nueva solicitud de socio')
            ->greeting('¡Hola!')
            ->line('Se ha recibido una nueva solicitud de socio:')
            ->line('Nombre: ' . $this->solicitud->user->nombre . ' ' . $this->solicitud->user->apellidos)
            ->line('Email: ' . $this->solicitud->user->email)
            ->line('Teléfono: ' . ($this->solicitud->telefono ?? 'No indicado'))
            ->line('DNI: ' . $this->solicitud->dni)
            ->line('Fecha: ' . $this->solicitud->created_at->format('d/m/Y H:i'))
            ->action('Ver solicitudes', url('/panel/instructor/solicitudes'))
            ->line('Revisar y gestionar la solicitud desde el panel de administración.');
    }
}
