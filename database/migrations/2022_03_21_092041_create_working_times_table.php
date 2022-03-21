<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('working_times', function (Blueprint $table) {
            $table->id();

            /*
             * Вначале создаём поле 'user_id',
             * а потом обозначем его внешним ключом.
             */
            $table->unsignedBigInteger('user_id')->comment('ID работника');
            $table->foreign('user_id')->references('id')->on('users');

            // Дата рабочего дня и время начала работы получают значения при создании.
            $table->date('date')->useCurrent()->comment('Дата рабочего дня');
            $table->time('begin')->useCurrent()->comment('Время начала рабочего дня');
            // А вот время окончания дня должно сохраняться при обновлении.
            $table->time('end')->useCurrentOnUpdate()->comment('Время конца рабочего дня');
            $table->text('description')->comment('Описание того, что было сделано в этот день.');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('working_times');
    }
};
