<?php

namespace App\Notifications;

use App\Notifications\Messages\SmsMessage;
use App\Notifications\Messages\TelegramMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Log;

class VerificationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected string $code;
    protected string $method;

    /**
     * Create a new notification instance.
     *
     * @param string $code
     * @param string $method
     */
    public function __construct(string $code, string $method)
    {
        $this->code = $code;
        $this->method = $method;
    }

    /**
     * Determine which channels the notification should be sent on.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via(mixed $notifiable): array
    {
        return match ($this->method) {
            'sms', 'telegram' => ['log'],
            default => ['mail'],
        };
    }

    /**
     * Send the notification via email.
     *
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail(mixed $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Ваш код подтверждения')
            ->line('Используйте следующий код для подтверждения изменения настройки:')
            ->line($this->code)
            ->line('Этот код истечет через 10 минут.');
    }

    /**
     * Log the notification for testing SMS and Telegram.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toLog(mixed $notifiable): array
    {
        $message = match ($this->method) {
            'sms' => 'SMS: Ваш код подтверждения: ' . $this->code,
            'telegram' => 'Telegram: Ваш код подтверждения: ' . $this->code,
            default => 'Unknown notification method',
        };

        return ['message' => $message];
    }
}
