<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run()
    {
        $tags = Tag::factory(5)->create();

        // Создаем задачи с привязкой тегов
        Task::factory(10)->create()->each(function ($task) use ($tags) {
            // Привязываем теги к каждой задаче
            $task->tags()->attach($tags->random(2)->pluck('id')); // Привязываем 2 случайных тега
        });
    }
}
