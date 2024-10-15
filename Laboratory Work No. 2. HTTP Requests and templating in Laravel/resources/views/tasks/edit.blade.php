{{--@extends('layouts.app')--}}

{{--@section('content')--}}
{{--    <div class="container mt-4 d-flex justify-content-center">--}}
{{--        <div class="card shadow" style="width: 100%; max-width: 800px; padding: 20px;">--}}
{{--            <div class="card-header bg-info text-white">--}}
{{--                <h4 class="mb-0">Редактировать задачу</h4>--}}
{{--            </div>--}}
{{--            <div class="card-body">--}}
{{--                <form action="{{ route('tasks.update', $task->id) }}" method="POST">--}}
{{--                    @csrf--}}
{{--                    @method('PUT')--}}

{{--                    <div class="mb-4 row">--}}
{{--                        <label for="title" class="col-sm-3 col-form-label text-start">Название</label>--}}
{{--                        <div class="col-sm-9">--}}
{{--                            <input type="text" name="title" id="title" class="form-control" value="{{ $task->title }}" required>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="mb-4 row">--}}
{{--                        <label for="description" class="col-sm-3 col-form-label text-start">Описание</label>--}}
{{--                        <div class="col-sm-9">--}}
{{--                            <textarea name="description" id="description" class="form-control" rows="4" required>{{ $task->description }}</textarea>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="mb-4 row">--}}
{{--                        <label for="category_id" class="col-sm-3 col-form-label text-start">Категория</label>--}}
{{--                        <div class="col-sm-9">--}}
{{--                            <select name="category_id" id="category_id" class="form-select" required>--}}
{{--                                @foreach ($categories as $category)--}}
{{--                                    <option value="{{ $category->id }}" {{ $task->category_id == $category->id ? 'selected' : '' }}>--}}
{{--                                        {{ $category->name }}--}}
{{--                                    </option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="mb-4 row">--}}
{{--                        <label for="tags" class="col-sm-3 col-form-label text-start">Теги</label>--}}
{{--                        <div class="col-sm-9">--}}
{{--                            <select name="tags[]" id="tags" class="form-select" multiple>--}}
{{--                                @foreach ($tags as $tag)--}}
{{--                                    <option value="{{ $tag->id }}" {{ in_array($tag->id, $task->tags->pluck('id')->toArray()) ? 'selected' : '' }}>--}}
{{--                                        {{ $tag->name }}--}}
{{--                                    </option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="d-flex justify-content-end">--}}
{{--                        <button type="submit" class="btn btn-warning">Обновить задачу</button>--}}
{{--                    </div>--}}
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
                <h4 class="mb-0 text-center">Редактировать задачу</h4>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="title" class="form-label">Название</label>
                        <input type="text" name="title" id="title" class="form-control" value="{{ $task->title }}" required>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label">Описание</label>
                        <textarea name="description" id="description" class="form-control" rows="4" required>{{ $task->description }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label for="category_id" class="form-label">Категория</label>
                        <select name="category_id" id="category_id" class="form-select" required>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ $task->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="tags" class="form-label">Теги</label>
                        <select name="tags[]" id="tags" class="form-select" multiple>
                            @foreach ($tags as $tag)
                                <option value="{{ $tag->id }}" {{ in_array($tag->id, $task->tags->pluck('id')->toArray()) ? 'selected' : '' }}>
                                    {{ $tag->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-warning btn-lg">Обновить задачу</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        /* Стили для карточки редактирования задачи */
        .card-header {
            background: linear-gradient(135deg, #17a2b8, #138496);
            border-bottom: 2px solid #138496;
        }

        .card {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .form-label {
            font-weight: bold;
            color: #333;
        }

        .form-control:focus {
            border-color: #17a2b8;
            box-shadow: 0 0 5px rgba(23, 162, 184, 0.5);
        }

        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
            transition: background-color 0.3s, border-color 0.3s;
            font-weight: bold;
        }

        .btn-warning:hover {
            background-color: #e0a800;
            border-color: #d39e00;
        }

    </style>
@endsection
