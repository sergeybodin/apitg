<?php

namespace App\Console\Commands;

use App\Jobs\MovieSendInAdmin;
use App\Jobs\MovieSendInGroup;
use App\Models\Tasks\Task;
use App\Models\Tasks\TaskStatus;
use App\Models\Tasks\TaskType;
use Illuminate\Console\Command;

class MovieSendInGroupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'movie:send:in:group';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Отправка по крону фильма зарегистрированным пользователям';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $tasks = Task::where(['status' => TaskStatus::NOT_IMPLEMENTED])->get();
        if ($tasks) {
            foreach ($tasks as $task) {
                switch ($task->type) {
                    case TaskType::SEND_MOVIE_GROUP:
                        $task->setPerformed();
                        MovieSendInGroup::dispatch($task);
                        break;
                    case TaskType::SEND_MOVIE_ADMIN:
                        $task->setPerformed();
                        MovieSendInAdmin::dispatch($task);
                        break;
                }
            }
        }
    }
}
