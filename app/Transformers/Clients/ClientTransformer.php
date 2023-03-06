<?php

namespace App\Transformers\Clients;

use App\Models\Clients\Client;
use League\Fractal\TransformerAbstract;

class ClientTransformer extends TransformerAbstract {
    protected array $defaultIncludes = [
    ];

    protected array $availableIncludes = [
    ];

    public function transform(Client $model): array {
        return [
            'id' => $model->id,
            'type' => $model->parsedType,
            'telegram_chat_id' => $model->telegram_chat_id,
        ];
    }
}
