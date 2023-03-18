<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BlogAcceptedByAdmin extends Notification
{
    use Queueable;

    private $blog_id;

    /**
     * Create a new notification instance.
     */
    public function __construct($blog_id)
    {
        $this->blog_id = $blog_id;
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
    public function toArray(object $notifiable): array
    {
        return [
            'blog_id' => $this->blog_id,
            'message' => 'Your blog accepted by admin! Thank you.'
        ];
    }
}
