<?php

namespace App\Providers;

use App\Models\User;
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
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define(env("IS_ADMIN"), function (User $user) {
            return $user->id === 1;
        });

        Gate::define(env("IS_DIRECTOR"), function (User $user) {
            return $user->role_id === 2;
        });

        Gate::define(env("IS_DISPATCHER"), function (User $user) {
            return $user->role_id === 3;
        });

        Gate::define(env("IS_DRIVER"), function (User $user) {
            return $user->role_id === 4;
        });

        Gate::define(env("IS_WAREHOUSEMAN"), function (User $user) {
            return $user->role_id === 5;
        });

        Gate::define(env("IS_CLIENT"), function (User $user) {
            return $user->role_id === 6;
        });
    }
}
