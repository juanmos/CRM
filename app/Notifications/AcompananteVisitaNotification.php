<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\FcmNotification;
use NotificationChannels\Apn\ApnChannel;
use NotificationChannels\Apn\ApnMessage;
use Carbon\Carbon;

class AcompananteVisitaNotification extends Notification
{
    use Queueable;
    private $tipo;
    private $visita;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($tipo, $visita)
    {
        $this->tipo=$tipo;
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
        return [FcmChannel::class, ApnChannel::class,'mail'];
    }

    public function toFcm($notifiable)
    {
        // The FcmNotification holds the notification parameters
        $fcmNotification = FcmNotification::create()
            ->setTitle('Has sido '.$this->tipo.' como acompañante en una visita')
            ->setBody('Ingresa a la aplicación para ver la visita.');
            
            
        // The FcmMessage contains other options for the notification
        return FcmMessage::create()
            ->setPriority(FcmMessage::PRIORITY_HIGH)
            ->setTimeToLive(86400)
            ->setNotification($fcmNotification)
            ->setData(["visita_id"=>$this->visita->id,"tipo"=>"acompanante"]);
        ;
    }

    public function toApn($notifiable)
    {
        return ApnMessage::create()
            ->badge(1)
            ->title('Has sido '.$this->tipo.' como acompañante en una visita')
            ->body('Ingresa a la aplicación para ver la visita.')
            ->custom("visita_id", $this->visita->id)
            ->custom("tipo", 'acompanante');
        ;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = route('visita.show', $this->visita->id);

        return (new MailMessage)
                    ->subject('Has sido '.$this->tipo.' como acompañante en una visita')
                    ->greeting('Estimad@ '.$notifiable->full_name)
                    ->line('Has sido '.$this->tipo.' como acompañante a visita con los siguientes datos: ')
                    ->line('Cliente: '.$this->visita->cliente->nombre)
                    ->line('Vendedor: '.$this->visita->vendedor->full_name)
                    ->line('La fecha de la visita es para el '.Carbon::parse($this->visita->fecha_inicio)->format('d-m-Y H:i'))
                    ->action('Ir a la visita', $url)
                    ->line('Muchas gracias por usuar nuestra aplicación!');
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
