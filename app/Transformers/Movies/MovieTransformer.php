<?php

namespace App\Transformers\Movies;

use App\Models\Movies\Movie;
use App\Transformers\Tasks\ClientTransformer;
use App\Transformers\Tasks\TaskTransformer;
use League\Fractal\Resource\Collection;
use League\Fractal\TransformerAbstract;

class MovieTransformer extends TransformerAbstract {
    protected array $defaultIncludes = [
    ];

    protected array $availableIncludes = [
        'tasks'
    ];

    public function transform(Movie $model): array {
        return [
            'id' => $model->id,
            'name_ru' => $model->name_ru,
            'name_en' => $model->name_en,
            'quality' => $model->quality,
            'year' => $model->year,
            'imdb_rating' => $model->imdb_rating,
            'views' => $model->views,
            'country' => $model->country,
            'description' => $model->description,
            'poster' => $model->poster,
            'trailer' => $model->trailer,
            'movie' => $model->movie,
        ];
    }

    public function includeTasks(Movie $model): Collection {
        return $this->collection($model->tasks, new TaskTransformer());
    }
}
