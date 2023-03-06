<?php

namespace App\Transformers\Users;

use App\Models\User;
use App\Transformers\Assets\AssetTransformer;
use App\Transformers\Companies\CompanyMemberTransformer;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;

/**
 * Class UserTransformer.
 */
class UserTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected array $defaultIncludes = [

	];

	protected array $availableIncludes = [
		'avatar', 'roles', 'membership'
	];

    /**
     * @param User $model
     * @return array
     */
    public function transform(User $model)
    {
        return [
            'id' => $model->uuid,
            'name' => $model->name,
			'first_name' => $model->first_name,
			'last_name' => $model->last_name,
            'abbreviation_name' => $model->parsedAbbreviationName,
            'email' => $model->email,
			'phone' => $model->phone,
			'created_at' => $model->created_at->toIso8601String()
        ];
    }

    public function includeAvatar(User $model): ?Item {
    	return $model->avatar ? $this->item($model->avatar, new AssetTransformer()) : null;
	}

    public function includeRoles(User $model): Collection {
        return $this->collection($model->roles, new RoleTransformer());
    }

    public function includeMembership(User $model): Collection {
    	return $this->collection($model->membership, new CompanyMemberTransformer());
	}
}
