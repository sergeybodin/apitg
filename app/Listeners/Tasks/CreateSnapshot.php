<?php

namespace App\Listeners\Tasks;

use App\Events\Tasks\TaskEvent;

class CreateSnapshot
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param TaskEvent $event
     * @return void
     */
    public function handle(TaskEvent $event) {
		$snapshot = $event->task->snapshots()->create(['member_id' => $event->task->member_id]);
		$snapshot->fillValues();
	}
}
