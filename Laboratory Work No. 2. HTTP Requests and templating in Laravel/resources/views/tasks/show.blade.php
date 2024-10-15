{{--@extends('layouts.app')--}}

{{--@section('content')--}}
{{--    <div class="container mt-4">--}}
{{--        <div class="card border-0 shadow">--}}
{{--            <div class="card-header bg-light">--}}
{{--                <h1 class="card-title mb-0">{{ $task->title }}</h1>--}}
{{--            </div>--}}
{{--            <div class="card-body">--}}
{{--                <p class="card-text">{{ $task->description }}</p>--}}

{{--                <p>--}}
{{--                    <strong>Категория:</strong>--}}
{{--                    <span class="badge bg-info">{{ $task->category->name }}</span>--}}
{{--                </p>--}}

{{--                <p>--}}
{{--                    <strong>Теги:</strong>--}}
{{--                    @foreach($task->tags as $tag)--}}
{{--                        <span class="badge bg-secondary">{{ $tag->name }}</span>--}}
{{--                    @endforeach--}}
{{--                </p>--}}
{{--            </div>--}}
{{--            <div class="card-footer bg-light text-end">--}}
{{--                <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-warning">Редактировать задачу</a>--}}

{{--                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Вы уверены, что хотите удалить эту задачу?');">--}}
{{--                    @csrf--}}
{{--                    @method('DELETE')--}}
{{--                    <button type="submit" class="btn btn-danger">Удалить задачу</button>--}}
{{--                </form>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--@endsection--}}

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

    <style>
        /* Стили для карточки задачи */
        .card-header {
            background: linear-gradient(135deg, #007bff, #0056b3);
            border-bottom: 2px solid #0056b3;
        }

        .card {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #fff;
        }

        .card-text {
            font-size: 1rem;
            color: #333;
        }

        .badge {
            margin-right: 5px;
        }

        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
            text-decoration: none;
            color:black;
            transition: background-color 0.3s, border-color 0.3s;
        }

        .btn-warning:hover {
            text-decoration: none;
            color:black;
            background-color: #e0a800;
            border-color: #d39e00;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
            transition: background-color 0.3s, border-color 0.3s;
        }

        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }

        .card-footer{
            display: flex;
            gap:15px;
            justify-content: center;
            margin-bottom: 10px;
        }
    </style>
@endsection


