@extends('layouts.app')

@section('content')
    <div class="container mt-4 d-flex justify-content-center">
        <div class="card shadow-lg" style="width: 100%; max-width: 800px; border-radius: 15px; overflow: hidden;">
            <div class="card-header bg-gradient text-white">
                <h4 class="mb-0 text-center">{{ $task->title }}</h4>
            </div>
            <div class="card-body p-4">
                <p class="card-text">{{ $task->description }}</p>

                <p>
                    <strong>Категория:</strong>
                    <span class="badge bg-info">{{ $task->category->name }}</span>
                </p>

                <p>
                    <strong>Теги:</strong>
                    @foreach($task->tags as $tag)
                        <span class="badge bg-secondary">{{ $tag->name }}</span>
                    @endforeach
                </p>
            </div>
            <div class="card-footer bg-light text-end">
                <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-warning">Редактировать задачу</a>

                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Вы уверены, что хотите удалить эту задачу?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Удалить задачу</button>
                </form>
            </div>
        </div>
    </div>
@endsection


