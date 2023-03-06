<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class Telegram
{

    protected $http;

    protected $bot;

    const url = 'https://api.tlgr.org/bot';

    public function __construct(Http $http, $bot)
    {
        $this->http = $http;
        $this->bot = $bot;
    }

    public function sendMessage($chatId, $message)
    {
        return $this->http::post(self::url . $this->bot . '/sendMessage', [
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => 'html'
        ]);
    }

    public function editMessage($chatId, $message, $messageId)
    {
        return $this->http::post(self::url . $this->bot . '/editMessageText', [
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => 'html',
            'message_id' =>$messageId
        ]);
    }

    public function sendDocument($chatId, $file, $replyId = null)
    {
        return $this->http::attach('document', $file)
            ->post(self::url . $this->bot . '/sendDocument', [
                'chat_id' => $chatId,
                'reply_to_message_id' => $replyId,
            ]);
    }

    public function sendButtons($chatId, $message, $buttons)
    {
        return $this->http::post(self::url . $this->bot . '/sendMessage', [
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => 'html',
            'reply_markup' => $buttons
        ]);
    }

    public function editButtons($chatId, $message, $buttons, $messageId)
    {
        return $this->http::post(self::url . $this->bot . '/editMessageText', [
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => 'html',
            'reply_markup' => $buttons,
            'message_id' =>$messageId
        ]);
    }

    public function sendPhoto($chatId, $photo, $caption, $replyMarkup = false)
    {
        return $this->http::post(self::url . $this->bot . '/sendPhoto', [
            'chat_id' => $chatId,
            'photo' => $photo,
            'caption' => $caption,
            'parse_mode' => 'html',
            'reply_markup' => $replyMarkup
        ]);
    }
}
