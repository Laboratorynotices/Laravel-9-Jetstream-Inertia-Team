<?php

namespace App\Providers;

use App\Models\Team;
use App\Models\User;
use App\Models\WorkingTime;
use App\Policies\TeamPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Team::class => TeamPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot() {
        $this->registerPolicies();

        /* Можно ли актуальному пользователю открывать
         * список всех пользователей.
         */
        Gate::define('workingTime.indexAll', function (User $user) {
            return $user->canWorkingTimeIndexAll();
        });

        /* Можно ли актуальному пользователю изменять запись
         */
        Gate::define('workingTime.edit', function (User $user, WorkingTime $workingTime) {
            return $workingTime->canBeEdited();
        });
    }
}
