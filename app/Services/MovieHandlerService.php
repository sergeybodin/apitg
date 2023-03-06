<?php

namespace App\Services;

use App\Helpers\Telegram;
use App\Jobs\MovieSendClient;
use App\Models\Chats\Chat;
use App\Models\Clients\Client;
use App\Models\Clients\ClientType;
use App\Models\Movies\Movie;
use App\Models\Tasks\Task;
use App\Models\Tasks\TaskStatus;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MovieHandlerService {

    public Telegram $telegram;

    public function __construct() {
    }

    public function sendInGroup($task) {
        $clients = Client::all();
        $task->update(['need_send' => count($clients)]);
        foreach ($clients as $client) {
            MovieSendClient::dispatch($task, $client->telegram_chat_id);
        }
    }

    public function sendInAdmin($task){
        $clients = Client::where(['type' => ClientType::ADMIN])->get();
        $task->update(['need_send' => count($clients)]);
        foreach ($clients as $client) {
            MovieSendClient::dispatch($task, $client->telegram_chat_id);
        }
    }

    public function sendClient(Telegram $telegram, Task $task, $telegramChatId) {

        $chat = Chat::create(['telegram_chat_id' => $telegramChatId, 'movie_id' => $task->movie->id]);

        $movie = Movie::where(['id' => $task->movie->id])->first();

        $reply_makeup = [
            'inline_keyboard' => [
                [
                    [
                        'text' => 'Cмотреть трейлер',
                        'callback_data' => 'show_trailer|'.$movie->id,
                    ]
                ],
                [
                    [
                        'text' => 'Купить',
                        'callback_data' => 'pay_movie|'.$movie->id
                    ]
                ]
            ]
        ];

        $response = $telegram->sendPhoto(
            $telegramChatId,
            $movie->poster,
            (string)view('sender.movie', ['movie' => $movie]),
            $reply_makeup,
        );

        if ($response) {
            $object = $response->object();
            if ($object->ok) {
                $chat->update(['message_id' => $object->result->message_id]);
                $update = [
                    'sent' => $task->sent + 1
                ];
                if ($task->need_send == $update['sent']) {
                    $update['status'] = TaskStatus::COMPLETED;
                }
                $task->update($update);
            }
        }

        //Storage::put('botCinemaResponsePost.txt', print_r($response->object()->ok, 1));
        //Log::debug($request->all());
    }
}
