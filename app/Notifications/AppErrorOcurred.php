<?php

namespace App\Notifications;

use App\Mail\AppErrorMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Mail;

class AppErrorOcurred extends Notification
{
    use Queueable;

    protected $adminMessage;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($adminMessage)
    {
        $this->adminMessage = $adminMessage;
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
        $adminEmail = $this->getAdminEmail();
        return (new AppErrorMail($this->adminMessage))->to($adminEmail);
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

    public function getAdminEmail() {
        return 'jgvillalba@dentix.es';
    }
}
