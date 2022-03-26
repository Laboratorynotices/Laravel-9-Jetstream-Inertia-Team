<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\WorkingTimeController; 

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

    /* Обзор зарегистрированного рабочего времени
     * этим пользователем.
     * Обычный вид.
     */
    Route::get('/workingTime',
        [WorkingTimeController::class, 'index']
    )->name('workingTime');

    /* Обзор зарегистрированного рабочего времени
     * всеми пользователями.
     * Административный вид.
     */
    Route::get('/workingTime/indexAll',
        [WorkingTimeController::class, 'indexAll']
    )->name('workingTime.index.all');

    /* Форма для добавления новой записи
     */
    Route::get('/workingTime/create',
        [WorkingTimeController::class, 'create']
    )->name('workingTime.create');

    /* Сохранение данных при создании формы
    */
    Route::post('/workingTime/store',
        [WorkingTimeController::class, 'store']
    )->name('workingTime.store');
});
