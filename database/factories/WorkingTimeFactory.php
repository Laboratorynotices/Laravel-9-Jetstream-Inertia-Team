<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WorkingTime>
 */
class WorkingTimeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition() {
        /* Генерируем два времени, позже определим,
         * которое из них начало рабочего дня,
         * а которое окончание.
         */
        $time1 = $this->faker->time();
        $time2 = $this->faker->time();
        return [
            /*
             * Генерирует число от 1 до 10.
             * По числу генерируемых пользователей
             * в database/seeders/UserSeeder.php
             */
            'user_id' => $this->faker->numberBetween(1,10),
            // Дата рабочего дня
            'date' => $this->faker->dateTimeBetween('-1 week', 'now'),
            // Начало рабочего дня, наименьшее из двух сгенерируемых
            'begin' => min($time1, $time2),
            // Конец рабочего дня, наибольшее из двух сгенерируемых
            'end' => max($time1, $time2),
            // Текст из 350 символов
            'description' => $this->faker->text(350)
        ];
    }
}
