@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="table-responsive">
            <table class="table todo-table">
                <thead>
                <tr class="todo-table-header">
                    <th style="text-align: center">Название</th>
                    <th style="text-align: center">Описание</th>
                    <th>Категория</th>
                    <th style="text-align: center">Теги</th>
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
                                <span class="badge bg-secondary">{{ $tag->name }},</span>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
