{{--@extends('layouts.app')--}}

{{--@section('content')--}}
{{--    <div class="container mt-4 d-flex justify-content-center">--}}
{{--        <div class="card shadow" style="width: 100%; max-width: 800px; padding: 20px;">--}}
{{--            <div class="card-header bg-primary text-white">--}}
{{--                <h4 class="mb-0">Создать задачу</h4>--}}
{{--            </div>--}}
{{--            <div class="card-body">--}}
{{--                <form action="{{ route('tasks.store') }}" method="POST">--}}
{{--                    @csrf--}}

{{--                    <div class="mb-4 row">--}}
{{--                        <label for="title" class="col-sm-3 col-form-label text-start">Название</label>--}}
{{--                        <div class="col-sm-9">--}}
{{--                            <input type="text" name="title" id="title" class="form-control" required placeholder="Введите название задачи">--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="mb-4 row">--}}
{{--                        <label for="description" class="col-sm-3 col-form-label text-start">Описание</label>--}}
{{--                        <div class="col-sm-9">--}}
{{--                            <textarea name="description" id="description" class="form-control" rows="4" required placeholder="Введите описание задачи"></textarea>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="mb-4 row">--}}
{{--                        <label for="category_id" class="col-sm-3 col-form-label text-start">Категория</label>--}}
{{--                        <div class="col-sm-9">--}}
{{--                            <select name="category_id" id="category_id" class="form-select" required>--}}
{{--                                <option value="" disabled selected>Выберите категорию</option>--}}
{{--                                @foreach ($categories as $category)--}}
{{--                                    <option value="{{ $category->id }}">{{ $category->name }}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="mb-4 row">--}}
{{--                        <label for="tags" class="col-sm-3 col-form-label text-start">Теги</label>--}}
{{--                        <div class="col-sm-9">--}}
{{--                            <select name="tags[]" id="tags" class="form-select" multiple>--}}
{{--                                @foreach ($tags as $tag)--}}
{{--                                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="d-flex justify-content-end">--}}
{{--                        <button type="submit" class="btn btn-success">Создать задачу</button>--}}
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
                <h4 class="mb-0 text-center">Создать задачу</h4>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('tasks.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="title" class="form-label">Название</label>
                        <input type="text" name="title" id="title" class="form-control" required placeholder="Введите название задачи">
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label">Описание</label>
                        <textarea name="description" id="description" class="form-control" rows="4" required placeholder="Введите описание задачи"></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="category_id" class="form-label">Категория</label>
                        <select name="category_id" id="category_id" class="form-select" required>
                            <option value="" disabled selected>Выберите категорию</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="tags" class="form-label">Теги</label>
                        <select name="tags[]" id="tags" class="form-select" multiple>
                            @foreach ($tags as $tag)
                                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary btn-lg w-100">Создать задачу</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        /* Добавляем стили для более современного вида */
        .card-header {
            background: linear-gradient(135deg, #007bff, #0056b3);
            border-bottom: 2px solid #0056b3;
        }

        .card {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .form-label {
            font-weight: bold;
            color: #333;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            transition: background-color 0.3s, border-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
    </style>
@endsection
