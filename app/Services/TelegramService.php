<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    private string $token;
    private string $chatId;

    public function __construct()
    {
        $this->token  = config('services.telegram.token');
        $this->chatId = config('services.telegram.chat_id');
    }

    public function send(string $message): void
    {
        if (empty($this->token) || empty($this->chatId)) {
            Log::warning('Telegram: token atau chat_id belum dikonfigurasi');
            return;
        }

        try {
            Http::post("https://api.telegram.org/bot{$this->token}/sendMessage", [
                'chat_id'    => $this->chatId,
                'text'       => $message,
                'parse_mode' => 'HTML',
            ]);
        } catch (\Exception $e) {
            Log::error('Telegram send error: ' . $e->getMessage());
        }
    }
}