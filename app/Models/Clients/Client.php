<?php

namespace App\Models\Clients;

use App\Models\Tasks\Task;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'telegram_chat_id',
    ];

    protected $hidden = [
        'id'
    ];

    public function getParsedTypeAttribute(): array {
        return ['name' => $this->type, 'title' => ClientType::TITLES[$this->type] ?? null];
    }
}
