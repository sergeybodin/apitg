<?php

namespace App\Support;

use App\Models\Objects\Values\RelationValue;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait RelationValuesTrait {
    public function relationValues(): MorphMany {
        return $this->morphMany(RelationValue::class, 'relatable');
    }
}
