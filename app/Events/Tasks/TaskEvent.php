<?php

namespace App\Events\Tasks;

use App\Models\Processes\Task;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskEvent {
	use Dispatchable, InteractsWithSockets, SerializesModels;

	public Task $task;
	public string $eventName;

	public function __construct(Task $task) {
		$this->task = $task;
	}

    public function broadcastOn(): PrivateChannel {
        return new PrivateChannel('channel-name');
    }
}
