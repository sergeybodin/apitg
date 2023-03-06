<?php

namespace Database\Seeders;

use Database\Seeders\Users\RoleTableSeeder;
use Database\Seeders\Users\UsersTableSeeder;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    public function run() {
        $this->call(RoleTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(MovieSeeder::class);
        $this->call(ClientSeeder::class);
    }
}
