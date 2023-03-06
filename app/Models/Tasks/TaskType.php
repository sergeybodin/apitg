<?php

namespace App\Models\Tasks;

class TaskType {
    public const SEND_MOVIE_GROUP = 'sendMovieGroup';
    public const SEND_MOVIE_ADMIN = 'sendMovieAdmin';

    public const TITLES = [
        self::SEND_MOVIE_GROUP => 'Отправить фильм в группу',
        self::SEND_MOVIE_ADMIN => 'Отправить фильм админам на проверку',
    ];
}