<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
        // Создаём команду
        // и через неё пользователей, привязанных к ней.
        $this->call([
            TeamSeeder::class
        ]);

        // Пользователи уже были созданы при создании команд.

        // Теперь создаём записи пользователей
        $this->call([
            WorkingTimeSeeder::class
        ]);
    }
}
