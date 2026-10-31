<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class OmnichannelNotifier
{
    public function sendTelegramAlert(string $chatId, string $message): bool
    {
        $token = (string) config('montly.notifications.telegram_bot_token');
        if ($token === '' || $chatId === '') {
            return false;
        }

        $response = Http::timeout(8)->post(
            "https://api.telegram.org/bot{$token}/sendMessage",
            [
                'chat_id'    => $chatId,
                'text'       => $message,
                'parse_mode' => 'HTML',
            ]
        );

        return $response->successful();
    }
}
