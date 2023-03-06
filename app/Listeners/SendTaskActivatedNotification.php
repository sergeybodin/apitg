<?php

namespace App\Listeners;

use App\Mail\TaskActivated;
use App\Notifications\TaskStatus;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class SendTaskActivatedNotification {
    public function __construct() {
    }

    public function handle(object $event) {
		try {
			$message = "Вы назначены ответственным за выполнение задания «{$event->task->condition->name}»";
			Notification::send($event->task->responsible->user, new TaskStatus($message, $event->task->uuid));
			Mail::to($event->task->responsible->user->email)->send(new TaskActivated($event->task));
		} catch (\Exception $exception) {}
    }
}
