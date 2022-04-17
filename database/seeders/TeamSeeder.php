<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Team;
use App\Models\User;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        // Создаём группу "сотрудники" ('Employee')
        Team::factory()
        // Передаём нужные параметры для группы
        ->state([
            'name' => 'Employee',
            // А так же будущего супер-пользователя
            'user_id' => User::factory()->state([
                'name' => 'User0',
                'email' => 'user0@gmail.com',
                'current_team_id' => 1,
            ])
        ])
        // Теперь генерируем десять обычных пользователей
        // hasAttached() служит для соединений типа n:m
        ->hasAttached(
            User::factory()
                ->count(10)
                // Благодаря sequence() можно добавить разных пользователей с различными индексами.
                ->sequence(fn ($sequence) => [
                    'name' => 'User'.($sequence->index+1),
                    'email' => 'user'.($sequence->index+1).'@gmail.com',
                    'current_team_id' => 1,
                ]),
            // Второй параметр hasAttached() описывает,
            // какие поля надо заполнить в переходной таблице при n:m соединении.
            ['role' => 'editor']
        )
        // Напоследок создадим одного "надсмоторщика"
        ->hasAttached(
            User::factory()
                ->count(1)
                ->sequence(fn ($sequence) => [
                    'name' => 'User'.($sequence->index+11),
                    'email' => 'user'.($sequence->index+11).'@gmail.com',
                    'current_team_id' => 1,
                ]),
            ['role' => 'observer']
        )
        ->create();

    }
}
