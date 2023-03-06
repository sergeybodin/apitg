<?php

namespace App\Support;

trait SortableTrait {
	protected static function bootSortableTrait() {
		static::creating(function ($model) {
			$model->order_num = $model->lastOrderNum() + 1;
		});
	}
}
