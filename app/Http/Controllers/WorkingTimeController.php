<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexAllWorkingTimeRequest;
use App\Http\Requests\StoreWorkingTimeRequest;
use App\Http\Requests\UpdateWorkingTimeRequest;
use App\Models\WorkingTime;
use App\Models\User;

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class WorkingTimeController extends Controller
{
    /** Сколько записей отображать на одной страничке при пагинации */
    private const PAGINATEPERPAGE = 5;

    /**
     * Обзор зарегистрированного рабочего времени
     * этим пользователем.
     * Обычный вид.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        // Считываем записи рабочего времени этого пользователя,
        $workingTimes = WorkingTime::where('user_id', Auth::id())
            // с падигнацией
            ->paginate(self::PAGINATEPERPAGE);

        return Inertia::render('WorkingTime', [
            'workingTimes' => $workingTimes
                // Проходимся по каждому найденному элементу.
                ->each(function ($item, $key) {
                    // Добавляем новый атрибут к модели,
                    $item->canBeEdited =
                        // а его значение "высчитываем".
                        $item->canBeEdited();
                }),
            // Данные для пагинации
            'workingTimesLinks' => $workingTimes->links()->getData(),
        ]);
    }

    /**
     * Обзор зарегистрированного рабочего времени
     * всеми пользователями.
     * Административный вид.
     *
     * @param  \App\Http\Requests\IndexAllWorkingTimeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function indexAll(IndexAllWorkingTimeRequest $request) {

        // Проверка можно ли пользователю смотреть этот список.
        $this->authorize('workingTime.indexAll');

        // Загружаем рабочие записи
        $workingTimes =
            // Проверяем "фильтр", "null" - это false
            ($request->usersSelect) ?
                // отображаем данные лишь одного пользователя
                WorkingTime::where('user_id', $request->usersSelect)
                    // Падигнация
                    ->paginate(self::PAGINATEPERPAGE)
                    ->appends(['usersSelect' => $request->usersSelect]) :
                // показываем всех пользователей
                WorkingTime::paginate(self::PAGINATEPERPAGE);

        return Inertia::render('WorkingTime', [
            // Считываем все записи рабочего времени
            'workingTimes' => $workingTimes
            // потом проходимся по каждому найденному элементу.
            ->each(function ($item, $key) {
                // Добавляем новый атрибут к модели,
                $item->canBeEdited =
                    // а его значение "высчитываем".
                    $item->canBeEdited();
            }),
            // Данные для пагинации
            'workingTimesLinks' => $workingTimes->links()->getData(),
            // Загружаем всех пользователей
            'users' => User::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return Inertia::render('WorkingTimeCreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreWorkingTimeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreWorkingTimeRequest $request) {

        // Подготовим данные для записи
        $workingTime = array(
            'user_id' => Auth::id(),
            'description' => $request->description,
            // воспользуемся хелпером now() (классом Carbon)
            'date' => now()->toDateString(),
            'begin' => now()->toTimeString(),
        );

        // Тут можно сделать валидацию

        WorkingTime::create(
            $workingTime
        );

        return redirect()->route('workingTime');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WorkingTime  $workingTime
     * @return \Illuminate\Http\Response
     */
    public function show(WorkingTime $workingTime)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WorkingTime  $workingTime
     * @return \Illuminate\Http\Response
     */
    public function edit(WorkingTime $workingTime) {
        // Проверка доступа
        $this->authorize('workingTime.edit', $workingTime);

        return Inertia::render('WorkingTimeEdit', [
            'workingTime' => $workingTime->toArray()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateWorkingTimeRequest  $request
     * @param  \App\Models\WorkingTime  $workingTime
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateWorkingTimeRequest $request, WorkingTime $workingTime) {
        // @TODO Валидация
 
        // Считываем входящие данные
        $input = $request->input();

        // Обновляем данные модели, которые были определены как "fillable"
        $workingTime->fill($input);

        // Добавляем время окончания рабочего дня
        $workingTime->end = now()->toTimeString();

        // Сохраняем данные
        $workingTime->save();

        // @TODO обработка, если запись данных не получится

        // Перенаправляемся к списку записей
        return redirect()->route('workingTime.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WorkingTime  $workingTime
     * @return \Illuminate\Http\Response
     */
    public function destroy(WorkingTime $workingTime)
    {
        //
    }
}
