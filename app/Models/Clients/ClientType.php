<?php

namespace App\Models\Clients;

class ClientType {
    public const USER = 'user';
    public const ADMIN = 'admin';

    public const TITLES = [
        self::USER => 'пользователь',
        self::ADMIN => 'администратор',
    ];
}