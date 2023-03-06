<?php

namespace App\Support;

use App\Models\Processes\Participant;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait ParticipatableTrait {
    public function participation(): MorphMany {
        return $this->morphMany(Participant::class, 'participatable');
    }
}
