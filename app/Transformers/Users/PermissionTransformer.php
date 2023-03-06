<?php

namespace App\Transformers\Users;

use App\Models\Permission;
use League\Fractal\TransformerAbstract;

/**
 * Class PermissionTransformer.
 */
class PermissionTransformer extends TransformerAbstract
{
    /**
     * @param \App\Models\Permission $model
     * @return array
     */
    public function transform(Permission $model)
    {
        return [
            'id' => $model->uuid,
            'name' => $model->name,
            'createdAt' => $model->created_at->toIso8601String(),
            'updatedAt' => $model->updated_at->toIso8601String(),
        ];
    }
}
