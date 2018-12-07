<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AdminResetPasswordNotification extends Notification
{
    use Queueable;

    //Tambahan projek untuk multiauth
    public $token;

    /**
     * Create a new notification instance.
     *
     * @return void
     */


    //tambahkan parameter token dan mengisi didalam method $this->token = $token;
    public function __construct($token)
    {
        $this->token = $token;
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

    //Ubah message untuk keperluan multiauth projek
    public function toMail($notifiable)
    {
        return (new MailMessage)
            //Mengubah message
            ->line('You are receiving this email because we received a password reset request for your account.')
            ->action('Reset Password', route('admin.password.reset', $this->token))
            ->line('Thank you for using our application!');
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
