<?php

namespace App\Notifications\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class LogChannel
{
    /**
     * Отправка уведомления в лог.
     *
     * @param mixed $notifiable
     * @param Notification $notification
     * @return void
     */
    public function send(mixed $notifiable, Notification $notification): void
    {
        if (method_exists($notification, 'toLog')) {
            $message = $notification->toLog($notifiable);
            Log::info($message);
        }
    }
}
