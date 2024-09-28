<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
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
        return view('tasks.index', ['tasks' => $tasks]);
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        return 'destroy';
    }

    public function show($id)
    {
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

        return view('tasks.show', ['task' => $tasks[$id]]);
    }

    public function edit($id)
    {
        return view('tasks.edit', ['id' => $id]);
    }

    public function update(Request $request, $id)
    {
        return $id + "update";
    }

    public function destroy($id)
    {
        return 'destroy' + $id;
    }
}
