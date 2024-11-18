@extends('layouts.app')

@section('content')
    <div class="container mt-4">

        <!-- Флеш-сообщение об успешном сохранении или ошибке -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="background-color: #28a745; color: white; border-left: 5px solid #218838; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                <strong>Успех!</strong> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="color: white;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="background-color: #dc3545; color: white; border-left: 5px solid #c82333; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                <strong>Ошибка!</strong> {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="color: white;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table todo-table">
                <thead>
                <tr class="todo-table-header">
                    <th style="text-align: center">Название</th>
                    <th style="text-align: center">Описание</th>
                    <th style="text-align: center">Дата выполнения</th>
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
                        <td>{{ $task->due_date }}</td>
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
