<?php

namespace App\Providers;

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
            $tasks = [
                1 => [
                    'id' => 1,
                    'title' => 'Купить продукты',
                    'description' => 'Сходить в магазин и купить продукты',
                    'status' => 'В процессе',
                    'priority' => 'Высокий',
                    'assignment' => 'Иван Иванов',
                    'created_at' => '2024-09-25',
                    'updated_at' => '2024-09-26'
                ],
                2 => [
                    'id' => 2,
                    'title' => 'Закончить проект',
                    'description' => 'Завершить проект для клиента',
                    'status' => 'Ожидается',
                    'priority' => 'Средний',
                    'assignment' => 'Петр Петров',
                    'created_at' => '2024-09-20',
                    'updated_at' => '2024-09-23'
                ]
            ];

            $lastTask = end($tasks);

            $view->with('lastTask', $lastTask);
        });
    }
}
