<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $loginInfo = [
            'name'      => 'Ollyo Server',
            'email'     => 'ollyo@gmail.com',
            'password'  => bcrypt('ollyopms'),
        ];
        User::insert($loginInfo);
    }
}
