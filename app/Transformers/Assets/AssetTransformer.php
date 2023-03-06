<?php

namespace App\Transformers\Assets;

use App\Models\Asset;
use App\Transformers\Users\UserTransformer;
use League\Fractal\TransformerAbstract;

/**
 * Class AssetTransformer.
 */
class AssetTransformer extends TransformerAbstract
{
	/**
	 * List of resources to automatically include
	 *
	 * @var array
	 */
	protected array $defaultIncludes = [
		'user', 'coordinates'
	];


	/**
     * @param Asset $model
     * @return array
     */
    public function transform(Asset $model)
    {
        return [
            'id' => $model->uuid,
            'type' => $model->type,
            'path' => $model->path,
            'mime' => $model->mime,
			'filename' => $model->filename,
			'extension' => $model->extension,
			'links' => $model->links(),
            'created_at' => $model->created_at ? $model->created_at->toIso8601String() : null,
        ];
    }

    public function includeUser(Asset $model) {
    	return $model->user ? $this->item($model->user, new UserTransformer()) : null;
	}

	public function includeCoordinates(Asset $model) {
    	return $this->primitive($model->coordinates());
	}
}
