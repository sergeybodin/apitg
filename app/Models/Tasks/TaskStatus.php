<?php

namespace App\Models\Tasks;

class TaskStatus {
    public const NOT_IMPLEMENTED = 'notImplemented';
    public const PERFORMED = 'performed';
    public const COMPLETED = 'completed';

    public const TITLES = [
        self::NOT_IMPLEMENTED => 'не выполнена',
        self::PERFORMED => 'выполняется',
        self::COMPLETED => 'выполнена',
    ];
}