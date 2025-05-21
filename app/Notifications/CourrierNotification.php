<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class CourrierNotification extends Notification
{
    use Queueable;

    public $courrier;

    /**
     * Create a new notification instance.
     */
    public function __construct($courrier)
    {
        $this->courrier = $courrier;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'id' => $this->courrier->id,
            'reference' => $this->courrier->reference,
            'objet' => $this->courrier->objet,
            'expediteur' => $this->courrier->expediteur->name ?? '',
            'created_at' => $this->courrier->created_at->format('d/m/Y H:i'),
        ];
    }
}
