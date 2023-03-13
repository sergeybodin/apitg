<?php

namespace App\Models\Chats;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'chat_id',
        'type',
    ];

    protected $hidden = [
        'id'
    ];
}
