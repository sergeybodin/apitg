<?php

namespace App\Jobs;

use App\Helpers\Telegram;
use App\Models\Tasks\Task;
use App\Services\MovieHandlerService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use phpDocumentor\Reflection\Types\This;

class MovieSendClient implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $task;

    public $telegramChatId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($task, $telegramChatId)
    {
        $this->task = $task;
        $this->telegramChatId = $telegramChatId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Telegram $telegram)
    {
        (new MovieHandlerService())->sendClient($telegram, $this->task, $this->telegramChatId);
    }
}
