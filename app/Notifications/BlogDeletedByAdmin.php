<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BlogDeletedByAdmin extends Notification
{
    use Queueable;

    private $blog_title;

    /**
     * Create a new notification instance.
     */
    public function __construct($blog_title)
    {
        $this->blog_title = $blog_title;
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
          'title' => $this->blog_title,
          'message' => 'Sorry.. Your blog deleted by admin! Thank you.'
        ];
    }
}
