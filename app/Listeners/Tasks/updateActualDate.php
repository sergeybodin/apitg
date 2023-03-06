<?php

namespace App\Listeners\Tasks;

use App\Events\Tasks\TaskEvent;

class updateActualDate {
    public function __construct() {
    }

    public function handle(TaskEvent $event) {
        if (($standard = $event->task->process->standard) && ($stage = $event->task->stage)) {
            if ($stage->parent && $stage->isLastSibling()) $standard->setDate($stage->parent->fsid, 'actual', now());
            $standard->setDate($stage->fsid, 'actual', now());
        }
    }
}
