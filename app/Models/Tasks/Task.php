<?php

namespace App\Models\Tasks;

use App\Models\Movies\Movie;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $dates = [
        'read_at'
    ];

    protected $fillable = [
        'movie_id',
        'type',
        'status',
        'need_send',
        'sent',
        'data',
        'read_at',
    ];

    protected $hidden = [
        'id'
    ];

    public function movie(): BelongsTo {
        return $this->belongsTo(Movie::class);
    }

    public function getParsedTypeAttribute(): array {
        return ['name' => $this->type, 'title' => TaskType::TITLES[$this->type] ?? null];
    }

    public function getParsedStatusAttribute(): array {
        return ['name' => $this->status, 'title' => TaskStatus::TITLES[$this->status] ?? null];
    }



    public function setPerformed(): void {
        $this->update(['status' => TaskStatus::PERFORMED]);
    }

    public function setCompleted(): void {
        $this->update(['status' => TaskStatus::COMPLETED]);
    }
}
