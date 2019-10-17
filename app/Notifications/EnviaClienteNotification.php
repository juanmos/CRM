<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class EnviaClienteNotification extends Notification
{
    use Queueable;
    private $visita;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($visita)
    {
        $this->visita=$visita;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = asset($this->visita->pdf);
        return (new MailMessage)
                    ->from($this->visita->vendedor->email,$this->visita->full_name)
                    ->greeting('Estimad@ '.$this->visita->cliente->nombre)
                    ->line('Le hemos enviado el detalle de la visita. Para poderlo ver por favor de click en el siguiente link.')
                    ->action('Ver detalle de visita', $url)
                    ->line('Cualquier novedad no dude en contactarnos');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
