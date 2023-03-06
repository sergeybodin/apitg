<?php

namespace App\Listeners\Tasks;

use App\Events\Tasks\TaskEvent;
use App\Models\Processes\Task;
use App\Services\TaskHandlerService;
use Illuminate\Support\Collection;

class CheckHandlers {
	public Task $task;

    public function __construct() {
    }

    public function handle(TaskEvent $event) {
    	if (($handlers = $event->task->demand->handlers) && is_array($handlers)) {
        	if (!empty($handlers[$event->eventName])) {
				$this->task = $event->task;
        		collect($handlers[$event->eventName])->each(function($handler) {
        			$this->applyHandler($handler);
				});
			}
		}
    }

    public function applyHandler($handler) {
    	if ($this->checkHandlerConditions($handler)) {
    	    $service = new TaskHandlerService($this->task);
			collect($handler['actions'])->each(function($action) use($service) {
				foreach ($action as $method => $data) {
                    if (method_exists($service, $method)) $service->$method($data);
                }
			});
		}
	}



	public function checkHandlerConditions($handler): bool {
    	if (!empty($handler['if'])) {
			foreach ($handler['if'] as $cond) {
				if (!$this->checkHandlerCondition($cond)) return false;
			}
		}
    	return true;
	}

	public function checkHandlerCondition($cond): bool {
		$result = false;
    	if (($prop = $cond['prop'] ?? null) && !empty($cond['cond'])) {
    		$value = $this->task->process->getValue($prop);
    	    $value = $this->prepareValue($value)->all();
    		$testValue = !empty($cond['value']) ? $this->prepareValue($cond['value'])->all() : [];
    		return $this->checkConditionValue($cond['cond'], $value, $testValue);
		}
    	return $result;
	}

	public function prepareValue($value): Collection {
    	return collect($value)->map(function($val) {
			if (is_array($val)) return $val['name'] ?? $val['uuid'] ?? $val['id'] ?? null;
			elseif (is_object($val)) return $val->name ?? $val->uuid ?? $val->id;
    		return $val;
		})->filter(function($val) {
			return !empty($val);
		})->values();
	}

	public function checkConditionValue($cond, $value, $testValue): bool {
		$result = false;
    	if ($cond === 'eq') $result = $value == $testValue;
		elseif ($cond === 'not-eq') $result = $value != $testValue;
		elseif ($cond === 'in') $result = !!array_intersect($value, $testValue);
		elseif ($cond === 'not-in') $result = !array_intersect($value, $testValue);
		return $result;
	}

}
