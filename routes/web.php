<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\WorkingTimeController; 
use App\Models\WorkingTime;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])
    ->group(function () {

    // Стартовая страничка административной части
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // Используем префикс в пути и имени маршрутов
    Route::prefix('workingTime')->name('workingTime.')->group(function () {
        /* Обзор зарегистрированного рабочего времени
         * этим пользователем.
         * Обычный вид.
         */
        Route::get('/index',
            [WorkingTimeController::class, 'index']
        )->name('index');

        /* Обзор зарегистрированного рабочего времени
         * всеми пользователями.
         * Административный вид.
         */
        Route::get('/indexAll',
            [WorkingTimeController::class, 'indexAll']
        )->name('index.all');

        /* Форма для добавления новой записи
         */
        Route::get('/create',
            [WorkingTimeController::class, 'create']
        )->name('create');

        /* Сохранение данных при создании формы
         */
        Route::post('/store',
            [WorkingTimeController::class, 'store']
        )->name('store');

        // Форма для редактирования записи
        Route::get('/edit/{workingTime}',
            // указание на контроллер и метод
            [WorkingTimeController::class, 'edit']
        )
        // фильтр по входящему параметру
        ->whereNumber('workingTime')
        // наименование маршрута
        ->name('edit');

        // Обработка данных, полученных от формы
        Route::post('/update/{workingTime}',
            // указание на контроллер и метод
            [WorkingTimeController::class, 'update']
        )
        // фильтр по входящему параметру
        ->whereNumber('workingTime')
        // наименование маршрута
        ->name('update');
    });
});
