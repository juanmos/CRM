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

class CambiosVisitaNotification extends Notification
{
    use Queueable;
    private $visita=null;
    private $fecha=null;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($visita,$fecha)
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
            ->setTitle('Hay cambios en tu visita')
            ->setBody('Ingresa a la aplicación para ver la visita.');
            
            
        // The FcmMessage contains other options for the notification
        return FcmMessage::create()
            ->setPriority(FcmMessage::PRIORITY_HIGH)
            ->setTimeToLive(86400)
            ->setNotification($fcmNotification)
            ->setData(["visita_id"=>$this->visita,"tipo"=>"visita","fecha"=>$this->fecha]);;
    }

    public function toApn($notifiable)
    {
        return ApnMessage::create()
            ->badge(1)
            ->title('Hay cambios en tu visita')
            ->body('Ingresa a la aplicación para ver la visita.')
            ->custom("visita_id",$this->visita)
            ->custom("tipo",'visita')
            ->custom("fecha",$this->fecha);;
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
                    ->line('Existen cambios en la visita agendada con el cliente: ')
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
