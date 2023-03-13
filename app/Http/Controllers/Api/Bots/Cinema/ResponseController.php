<?php

namespace App\Http\Controllers\Api\Bots\Cinema;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Telegram\Bot\Api;
use ErrorException;

class ResponseController extends Controller {
    public function post(Request $request) {
        try {
            $callback_query = $request->get('callback_query');
            $data = [
                'message_id' => $callback_query['message']['message_id'],
                'client' => $callback_query['from'],
                'data' => $callback_query['data'],
            ];
            Storage::put('botCinemaResponsePost.txt', print_r($data,1));
        } catch (ErrorException $exception) {
            Storage::put('exception.txt', print_r($exception->getTraceAsString(),1));
        }
    }
    public function webHook() {
        $telegram = new Api(config('bot.token'));
        return $telegram->getWebhookUpdates();
    }
}
