<?php

namespace App\Providers;

use App\Models\Favorite;
use App\Models\Thread;
use App\Models\User;
use App\Policies\FavoritePolicy;
use App\Policies\ThreadPolicy;
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
        Favorite::class => FavoritePolicy::class,
        Thread::class => ThreadPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function (User $user) {
            if ($user->name === 'John Doe') {
                return true;
            }
        });
    }
}
