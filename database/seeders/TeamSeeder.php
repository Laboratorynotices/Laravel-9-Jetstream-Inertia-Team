<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        // Создаём группу сотрудников
        DB::table('teams')->insert([
            'user_id'       => '1',
            'name'          => 'Employee',
            'personal_team' => '1',
        ]);
    }
}
