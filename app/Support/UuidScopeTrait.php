<?php

namespace App\Support;

use Illuminate\Support\Str;

trait UuidScopeTrait {
    public function scopeByUuid($query, $uuid) {
        return $query->where('uuid', $uuid);
    }

    public function scopeByUuidOrName($query, $uuid) {
        return $query->orWhere(['uuid' => $uuid, 'name' => $uuid]);
    }

    protected static function bootUuidScopeTrait() {
        static::creating(function ($model) {
            if (empty($model->uuid)) $model->uuid = (string) Str::uuid();
        });
    }
}
