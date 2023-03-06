<?php

namespace App\Events\Tasks;

use App\Models\Processes\Task;

class Skipped extends TaskEvent {
	public function __construct(Task $task) {
		parent::__construct($task);
		$this->eventName = 'skipped';
	}
}
