<?php

namespace App\Events\Tasks;

use App\Models\Processes\Task;

class ExecutorsChanged extends TaskEvent {
	public array $changes = [];

	public function __construct(Task $task, $changes) {
        parent::__construct($task);
        $this->changes = $changes;
    }
}
