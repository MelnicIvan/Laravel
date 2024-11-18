<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTaskRequest extends FormRequest
{
    /**
     * Определяем, авторизован ли пользователь для выполнения этого запроса.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // разрешаем все пользователи, в зависимости от требований можно добавить проверки на авторизацию
    }

    /**
     * Получаем правила валидации, которые должны быть применены к данным запроса.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|min:3|max:255', // обязательное поле, строка, минимальная длина 3 символа
            'description' => 'nullable|string|max:500', // необязательное поле, строка, максимальная длина 500 символов
            'due_date' => 'required|date|after_or_equal:today', // обязательная дата, не меньше сегодняшней
            'category_id' => 'required|exists:categories,id', // обязательное поле, должно быть существующим id категории
            'tags' => 'nullable|array', // необязательное поле, массив тегов
            'tags.*' => 'exists:tags,id', // каждый тег должен существовать в таблице tags
        ];
    }

    /**
     * Получаем сообщения об ошибках для пользовательских атрибутов.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => 'Название задачи обязательно.',
            'title.min' => 'Название должно содержать минимум 3 символа.',
            'due_date.after_or_equal' => 'Дата выполнения не может быть раньше сегодняшнего дня.',
            'category_id.exists' => 'Выбранная категория не существует.',
            'tags.*.exists' => 'Один или несколько тегов не существуют.',
        ];
    }
}
