<?php

namespace App\Providers;

use App\Models\Channel;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // This runs before database migrations on tests
        // View::share('channels', Channel::all());

        View::composer('*', function ($view) {
            $view->with('channels', Channel::all());
        });

        Paginator::useBootstrap();
    }
}
