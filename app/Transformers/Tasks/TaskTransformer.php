<?php

namespace App\Transformers\Tasks;

use App\Models\Tasks\Task;
use App\Transformers\Movies\MovieTransformer;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;

class TaskTransformer extends TransformerAbstract {
    protected array $defaultIncludes = [
    ];

    protected array $availableIncludes = [
        'movie'
    ];

    public function transform(Task $model): array {
        return [
            'id' => $model->id,
            'type' => $model->parsedType,
            'status' => $model->parsedStatus,
            'need_send' => $model->need_send,
            'sent' => $model->sent,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at,
        ];
    }

    public function includeMovie(Task $model): ?Item {
        return $model->movie ? $this->item($model->movie, new MovieTransformer()) : null;
    }
}
