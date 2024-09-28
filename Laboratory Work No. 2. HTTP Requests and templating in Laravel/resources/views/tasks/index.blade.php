@extends('layouts.app')

@section('title', 'Список задач')

@section('header', 'Все задачи')

@section('content')
    <h3 class="table-title">Список задач</h3>
    <table class="todo-table">
        <tr class="todo-table-row-title">
            <th>Название</th>
            <th>Описание</th>
        </tr>
        @foreach($tasks as $task)
            <tr class="todo-table-row">
                <th><a class="task-link" href="{{ route('tasks.show', $task['id']) }}">{{ $task['title'] }}</a></th>
                <th>{{ $task['description'] }}</th>
            </tr>
        @endforeach
    </table>
@endsection
