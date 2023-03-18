<?php

namespace App\Notifications;

use App\Models\Picture;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PictureNotification extends Notification
{
    use Queueable;

    private Picture $picture;

    /**
     * Create a new notification instance.
     *
     * @param Picture $picture
     */
    public function __construct(Picture $picture)
    {
        $this -> picture = $picture;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
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
            'message' => $this -> picture -> user -> name.'さんが画像を投稿しました',
            'id' => $this -> picture -> id,
        ];
    }
}
