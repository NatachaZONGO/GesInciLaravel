<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendNotiAffectationInci extends Notification
{
    use Queueable;
    protected $incident;
    /**
     * Create a new notification instance.
     */
    public function __construct($incident)
    {
        $this->incident = $incident; 
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
                    ->subject('Notification Affectation Incident')
                    ->line('Un nouvel incident vous a été affecté.')
                    ->action('Voir l\'incident', url('/incidents/' . $this->incident->id))
                    ->line('Merci pour vos services!');
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
