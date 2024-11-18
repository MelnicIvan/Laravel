<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Tag;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'due_date' => $this->faker->dateTimeBetween('now', '+1 year'), // Дата выполнения не меньше текущей
            'category_id' => Category::inRandomOrder()->value('id') ?? Category::factory(), // Существующая категория или новая
        ];
    }

    /**
     * Привязка тегов к задаче.
     */
    public function withTags($tagsCount = 3)
    {
        return $this->afterCreating(function (Task $task) use ($tagsCount) {
            // Выбираем случайные теги из существующих или создаём новые, если их недостаточно
            $tags = Tag::inRandomOrder()->take($tagsCount)->pluck('id');

            // Если тегов в базе меньше запрошенного количества, создаём недостающие
            if ($tags->count() < $tagsCount) {
                $newTags = Tag::factory($tagsCount - $tags->count())->create();
                $tags = $tags->merge($newTags->pluck('id'));
            }

            $task->tags()->sync($tags); // Привязываем теги к задаче
        });
    }


}
