<?php

namespace App\Support;

use App\Models\Classification\Code;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Str;

trait ClassifiableTrait {
    public function codes(): MorphToMany {
        return $this->morphToMany(Code::class, 'classifiable', 'classifiable')->withTimestamps();
    }

    public function setCodes($codes) {
        $codes = collect($codes)->map(function($code) {
            return trim(Str::replace(' ', '', $code));
        })->all();
        $this->codes()->sync(Code::query()->whereIn('name', $codes)->orWhereIn('uuid', $codes)->pluck('id')->all());
    }

}
