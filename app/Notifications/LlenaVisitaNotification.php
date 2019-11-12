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

class LlenaVisitaNotification extends Notification
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
            ->setTitle('Llena los datos de la visita')
            ->setBody('Ingresa a la aplicación para llenar los datos de la visita.');
            
            
        // The FcmMessage contains other options for the notification
        return FcmMessage::create()
            ->setPriority(FcmMessage::PRIORITY_HIGH)
            ->setTimeToLive(86400)
            ->setNotification($fcmNotification)
            ->setData(["visita_id"=>$this->visita,"tipo"=>"llenaVisita"]);;
    }

    public function toApn($notifiable)
    {
        return ApnMessage::create()
            ->badge(1)
            ->title('Llena los datos de la visita')
            ->body('Ingresa a la aplicación para llenar los datos de la visita.')
            ->custom("visita_id",$this->visita)
            ->custom("tipo",'llenaVisita');;
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
                    ->line('La visita con el cliente: ')
                    ->line($visita->cliente->nombre)
                    ->line('Agendada para el '.Carbon::parse($visita->fecha_inicio)->format('d-m-Y H:i').' ha concluido, por favor llena la información de la visita')
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
