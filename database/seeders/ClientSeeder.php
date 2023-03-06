<?php

namespace Database\Seeders;

use App\Models\Clients\Client;
use App\Models\Clients\ClientType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientSeeder extends Seeder
{
    private $_items = [
        [
            'telegram_chat_id' => 1602817829,
            'type' => ClientType::ADMIN
        ], [
            'telegram_chat_id' => 1602817829,
            'type' => ClientType::USER
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->_items as $item) {
            Client::create($item);
        }
    }
}
