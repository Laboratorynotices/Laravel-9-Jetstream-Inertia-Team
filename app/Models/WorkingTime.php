<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Auth;

class WorkingTime extends Model
{
    use HasFactory;

    /** Всегда автоматически подгружать данные пользователей,
     * чтобы их тут же передавать в вид. 
     */
    protected $with = array('user');

    /** Поля, которые можно сохранять группой
     * @var array
     */
    protected $fillable = ['user_id', 'date', 'description', 'begin', 'end'];

    /**
     * Get the user that owns the record.
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    /**
     * Можно ли изменять эту запись.
     */
    public function canBeEdited(): bool {
        // Получаем группу сотрудников.
        $employeeTeam = Team::getEmployeeTeam();

        // Получаем данные активного пользователя
        $user = Auth::user();

        // Является ли активный пользователь админом в группе сотрудников
        if ($user->hasTeamRole($employeeTeam, 'admin'))
            return true;

        // Является ли этот пользователь "обычным пользователем" (редактором)
        if ($user->hasTeamRole($employeeTeam, 'editor') &&
            // Принадлежит ли эта запись активному пользователю
            $this->user_id == $user->id &&
            // Поле окончание рабочего дня ещё хранит значение NULL
            $this->end === NULL)
            return true;

        return false;
    }
}
