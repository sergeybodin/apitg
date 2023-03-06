<?php

namespace App\Listeners\Tasks;

use App\Events\Tasks\TaskEvent;
use App\Mail\TaskDeadlineIncoming;
use App\Notifications\TaskStatus;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class NotifyDeadlineIncoming {
    public function __construct() {
    }

    public function handle(TaskEvent $event) {
        try {
            Notification::send($event->task->responsible->user, new TaskStatus($event->task->deadlineMessage, $event->task->uuid));
            Mail::to($event->task->responsible->user->email)->send(new TaskDeadlineIncoming($event->task));
        } catch (\Exception $exception) {}
    }
}
