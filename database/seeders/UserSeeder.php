<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        // Создадим десять пользователей обычных сотрудников
        for ($i=1; $i <= 10; $i++) {
            DB::table('users')->insert([
                'name' => 'User'.$i,
                'email' => 'user'.$i.'@gmail.com',
                'password' => Hash::make('password'),
                'current_team_id' => 1,
            ]);
        }
    }
}
