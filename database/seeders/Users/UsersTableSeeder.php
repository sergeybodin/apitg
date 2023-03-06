<?php

namespace Database\Seeders\Users;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder {
	public array $users = [

	];

	public array $admins = [
		['email' => 'sergey@bodin.ru', 'name' => 'Сергей'],
	];

    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run() {
        $this->createUsers($this->users);
        $this->createUsers($this->admins, 'Administrator');
    }

    public function createUsers($users, $role = 'User') {
    	foreach ($users as $k => $data) {
			if (!empty($data['email'])) {
				if ($user = User::where(['email' => $data['email']])->first()) $user->update($data);
				else User::factory()->create($data)->assignRole($role);
			}
		}
	}
}
