<?php

namespace App\Providers;

use App\Models\Task;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('home', function ($view) {
            $lastTask = Task::latest()->first();
            $view->with('lastTask', $lastTask);
        });
    }
}
