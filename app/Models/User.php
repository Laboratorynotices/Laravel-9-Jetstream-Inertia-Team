<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Привязываем записи рабочих сессий к пользователю
     * 
     * @return app/Models/WorkingTime
     */
    public function workingTimes() {
        return $this->hasMany(WorkingTime::class);
    }

    /**
     * Возвращает список "открытых" сессий,
     * у которых нет данных об окончании,
     * для этого пользователя.
     * 
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function openedWorkSessions() {
        return $this->workingTimes()->where('end', NULL);
    }

    /**
     * Возвращает одну (первую) "открытую" сессию,
     * у которой нет данных об окончании,
     * для этого пользователя.
     * 
     * @return App\Models\WorkingTime
     */
    public function openedWorkSession() {
        return $this->openedWorkSessions()->first();
    }

    /**
     * Возвращает номер этой "открытой" сессии.
     * 
     * @return Interger
     */
    public function openedWorkSessionID() {
        /* Проверка сделана на случай,
         * если у этого пользователя нет "открытых" записей.
         */ 
        return is_null($this->openedWorkSession()) ?
                null :
                $this->openedWorkSession()->id;
    }

    /**
     * Определяет есть ли "открытые" сессии.
     * 
     * @return Boolean
     */
    public function isSomeOpenedWorkSession() {
        return !is_null($this->openedWorkSession());
        // Альтернатива
        //return $this->openedWorkSessions->isNotEmpty();
    }
}
