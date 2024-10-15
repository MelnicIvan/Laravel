@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="table-responsive">
            <table class="table todo-table">
                <thead>
                <tr class="todo-table-header">
                    <th>Название</th>
                    <th style="text-align: center">Описание</th>
                    <th>Категория</th>
                    <th>Теги</th>
                </tr>
                </thead>
                <tbody>
                @foreach($tasks as $task)
                    <tr class="todo-table-row">
                        <td>
                            <a class="task-link" href="{{ route('tasks.show', $task->id) }}">{{ $task->title }}</a>
                        </td>
                        <td>{{ Str::limit($task->description, 100) }}</td>
                        <td>{{ $task->category->name }}</td>
                        <td>
                            @foreach($task->tags as $tag)
                                <span class="badge bg-secondary">{{ $tag->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <style>


        .todo-table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            border-radius: 15px;
            overflow: hidden;
        }

        .todo-table-header {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: #fff;
            text-align: left;
        }

        .todo-table th, .todo-table td {
            padding: 15px;
            border: 1px solid #ddd;
            vertical-align: middle;
            transition: background-color 0.3s;
        }

        .todo-table-row:hover {
            background-color: #f1f1f1;
        }

        .task-link {
            color: #007bff;
            text-decoration: none;
            transition: color 0.3s;
        }

        .task-link:hover {
            color: #0056b3;
            text-decoration: underline;
        }

        .badge {
            margin-right: 5px;
        }

        .badge:hover {
            background-color: #5a6268; /* Цвет фона для тегов при наведении */
            cursor: pointer; /* Указатель курсора при наведении */
        }
    </style>
@endsection
