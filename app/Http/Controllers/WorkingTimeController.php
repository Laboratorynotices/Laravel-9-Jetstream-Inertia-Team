<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWorkingTimeRequest;
use App\Http\Requests\UpdateWorkingTimeRequest;
use App\Models\WorkingTime;

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class WorkingTimeController extends Controller
{
    /**
     * Обзор зарегистрированного рабочего времени
     * этим пользователем.
     * Обычный вид.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return Inertia::render('WorkingTime', [
            // Считываем записи рабочего времени этого пользователя
            'workingTimes' => WorkingTime::where('user_id', Auth::id())->get(),
        ]);
    }

    /**
     * Обзор зарегистрированного рабочего времени
     * всеми пользователями.
     * Административный вид.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexAll() {
        return Inertia::render('WorkingTime', [
            // Считываем все записи рабочего времени
            'workingTimes' => WorkingTime::all(),
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
    public function edit(WorkingTime $workingTime)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateWorkingTimeRequest  $request
     * @param  \App\Models\WorkingTime  $workingTime
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateWorkingTimeRequest $request, WorkingTime $workingTime)
    {
        //
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
