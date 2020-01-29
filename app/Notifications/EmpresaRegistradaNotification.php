<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class EmpresaRegistradaNotification extends Notification
{
    use Queueable;
    private $user;
    private $password;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($usuario, $password)
    {
        $this->user=$usuario;
        $this->password=$password;
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
        $url=route('login');
        return (new MailMessage)
                ->subject('Nueva empresa registrada')
                ->greeting('Estimad@ '.$this->user->full_name)
                ->line('Te damos la bienvenida al CRM de '.$this->user->empresa->nombre)
                ->line('Ahora puedes iniciar sesión en el siguiente link, a continuación detallamos tus credenciales de ingreso')
                ->line('Email: '.$this->user->email)
                ->line('Contraseña: '.$this->password)
                ->action('Iniciar sesión', $url)
                ->line('Podrás completar tu perfil una vez dentro de la plataforma y cambiar tu contraseña')
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
