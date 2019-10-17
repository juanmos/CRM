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

class NuevaVisitaNotification extends Notification
{
    use Queueable;
    private $visita=null;

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
        return [FcmChannel::class, ApnChannel::class,'mail'];
    }

    public function toFcm($notifiable)
    {
        // The FcmNotification holds the notification parameters
        $fcmNotification = FcmNotification::create()
            ->setTitle('Nueva visita creada')
            ->setBody('Ingresa a la aplicación para ver tu agenda de visitas.');
            
            
        // The FcmMessage contains other options for the notification
        return FcmMessage::create()
            ->setPriority(FcmMessage::PRIORITY_HIGH)
            ->setTimeToLive(86400)
            ->setNotification($fcmNotification)
            ->setData(["visita_id"=>$this->visita,"tipo"=>"nuevaVisita"]);;
    }

    public function toApn($notifiable)
    {
        return ApnMessage::create()
            ->badge(1)
            ->title('Nueva visita creada')
            ->body('Ingresa a la aplicación para ver tu agenda de visitas.')
            ->custom("visita_id",$this->visita)
            ->custom("tipo",'nuevaVisita');;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $visita = Visita::find($this->visita);
        $url = route('visita.show',$this->visita);

        return (new MailMessage)
                    ->greeting('Estimad@ '.$visita->vendedor->full_name)
                    ->line('Tienes una visita agendada con el cliente: ')
                    ->line($visita->cliente->nombre)
                    ->line('La fecha de la nueva visita es para el '.Carbon::parse($visita->fecha_inicio)->format('d-m-Y H:i'))
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
