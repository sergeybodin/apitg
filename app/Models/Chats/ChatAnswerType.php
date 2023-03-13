<?php

namespace App\Models\Chats;

class ChatAnswerType
{
    public const MOVIE_PAYMENT = 'moviePayment';

    public const TITLES = [
        self::MOVIE_PAYMENT => 'Оплата фильма',
    ];
}
