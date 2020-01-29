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
use App\Models\Visita;
use Carbon\Carbon;

class CancelaVisitaNotification extends Notification
{
    use Queueable;
    private $visita=null;
    private $fecha=null;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($visita, $fecha)
    {
        $this->visita=$visita;
        $this->fecha=$fecha;
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
            ->setTitle('Visita cancelada')
            ->setBody('La visita al cliente '.$this->visita->cliente->nombre.' ha sido cancelada');
            
            
        // The FcmMessage contains other options for the notification
        return FcmMessage::create()
            ->setPriority(FcmMessage::PRIORITY_HIGH)
            ->setTimeToLive(86400)
            ->setNotification($fcmNotification)
            ->setData(["visita_id"=>$this->visita->id,"tipo"=>"visita","fecha"=>$this->fecha]);
        ;
    }

    public function toApn($notifiable)
    {
        return ApnMessage::create()
            ->badge(1)
            ->title('Visita cancelada')
            ->body('La visita al cliente '.$this->visita->cliente->nombre.' ha sido cancelada')
            ->custom("visita_id", $this->visita->id)
            ->custom("tipo", 'visita')
            ->custom("fecha", $this->fecha);
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
        $visita = $this->visita;
        $url = route('visita.show', $this->visita);

        return (new MailMessage)
                    ->subject('Visita cancelada')
                    ->greeting('Estimad@ '.$visita->vendedor->full_name)
                    ->line('Se ha cancelado la visita agendada con el cliente: ')
                    ->line($visita->cliente->nombre)
                    ->line('La fecha de la visita era para el '.Carbon::parse($visita->fecha_inicio)->format('d-m-Y H:i'))
                    ->line('Por la siguiente razon '.$visita->razon_cancelacion)
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
