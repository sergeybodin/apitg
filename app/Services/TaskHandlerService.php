<?php

namespace App\Services;

use App\Models\Tasks\Task;

class TaskHandlerService {
    public Task $task;

    public function __construct(Task $task) {
        $this->task = $task;
    }


//    public function startNextProcess($data) {
//        if (is_string($data)) {
//            if ($scenario = Scenario::query()->where('name', $data)->first()) {
//                $this->task->process->startNextProcess($scenario);
//            }
//        }
//    }
//
//    public function updateProcess($data) {
//        $this->task->process->update($data);
//    }
//
//    public function updateProcessable($data) {
//        $this->task->process->processable->update($data);
//    }
//
//
//    public function updateProduct($data) {
//        $product = $this->task->process->processable->product;
//        collect($data)->each(function($data, $prop) use($product) {
//            $value = (is_array($data) && !empty($data['prop'])) ? $this->task->getValue($data['prop']) : $data;
//            if ($prop === 'type') $product->update(['type_id' => $value->first()->id ?? null]);
//            else $product->setValue($prop, $value);
//        });
//    }
//
//
//    public function gotoStage($data) {
//        if ($stage = $this->task->process->scenario->stages()->where(['name' => $data])->first()) {
//            $this->task->process->goto($stage);
//        }
//    }


}
