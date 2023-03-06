<?php

namespace App\Models\Chats;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'telegram_chat_id',
        'movie_id',
        'message_id',
    ];

    protected $hidden = [
        'id'
    ];
}
