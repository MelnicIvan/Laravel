<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Получить правила валидации.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|min:3|max:255',
            'description' => 'nullable|string|max:500',
            'due_date' => 'required|date|after_or_equal:today',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ];
    }

    /**
     * Получить сообщения валидации.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'due_date.after_or_equal' => 'Дата выполнения должна быть не меньше сегодняшней.',
        ];
    }
}
