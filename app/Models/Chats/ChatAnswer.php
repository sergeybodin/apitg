<?php

namespace App\Models\Chats;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        '',
    ];

    protected $hidden = [
        'id'
    ];
}
