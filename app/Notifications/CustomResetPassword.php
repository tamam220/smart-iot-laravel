<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class CustomResetPassword extends Notification
{
    use Queueable;

    public $token;

    // Kita terima token dari request reset password
    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        // Buat URL reset password
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
            ->subject('Reset Password SmartIoT') 
            ->greeting('Halo, Commander!')      
            ->line('Sistem menerima permintaan untuk mereset password akun Anda.')
            ->action('BUAT PASSWORD BARU', $url)
            ->line('Link ini hanya berlaku selama 60 menit.')
            ->line('Jika bukan Anda yang memintanya, silakan abaikan pesan ini. Akun Anda tetap aman.')
            ->salutation('Salam, SmartIoT System');
    }
}