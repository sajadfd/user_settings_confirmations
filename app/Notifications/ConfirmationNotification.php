<?php

namespace App\Notifications;

use App\Models\Confirmation;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Messages\MailMessage;

class ConfirmationNotification extends Mailable
{
    use Queueable;

    private $confirmation;

    public function __construct(Confirmation $confirmation)
    {
        $this->confirmation = $confirmation;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('Your confirmation code is: ' . $this->confirmation->code_value)
            ->line('This code will expire in 10 minutes.')
            ->action('Confirm', url('/confirm/' . $this->confirmation->id))
            ->line('Thank you for using our service!');
    }

    public function toArray($notifiable)
    {
        return [
            'code_value' => $this->confirmation->code_value,
            'expiry_time' => $this->confirmation->expiry_time,
            'confirmation_method' => $this->confirmation->confirmation_method,
        ];
    }
}
