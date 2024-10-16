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
@endsection
