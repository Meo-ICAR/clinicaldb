<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeNewVersion extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public string $temporaryPassword)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Nuova versione di Archiprevaleat disponibile')
            ->greeting('Gentile '.$notifiable->name.',')
            ->line('La informiamo che è disponibile una nuova versione di ClinicalDB (già Archiprevaleat), più semplice e intuitiva da utilizzare, collegata alla nuova dashboard.')
            ->action('Accedi alla Dashboard', 'https://dashboard.archiprevaleat.com/')
            ->line('Per motivi di sicurezza la Sua password è stata reimpostata a: **'.$this->temporaryPassword.'**')
            ->line('Le consigliamo di cambiarla al primo accesso.')
            ->salutation('Cordiali saluti,'.PHP_EOL.'ClinicalDB (già Archiprevaleat)');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
