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
                        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" required value="{{ old('title') }}" placeholder="Введите название задачи">

                        @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label">Описание</label>
                        <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="4" placeholder="Введите описание задачи">{{ old('description') }}</textarea>

                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="due_date" class="form-label">Дата выполнения</label>
                        <input type="date" name="due_date" id="due_date" class="form-control @error('due_date') is-invalid @enderror" required value="{{ old('due_date') }}">

                        @error('due_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="category_id" class="form-label">Категория</label>
                        <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                            <option value="" disabled selected>Выберите категорию</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>

                        @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="tags" class="form-label">Теги</label>
                        <select name="tags[]" id="tags" class="form-select @error('tags') is-invalid @enderror" multiple>
                            @foreach ($tags as $tag)
                                <option value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', [])) ? 'selected' : '' }}>{{ $tag->name }}</option>
                            @endforeach
                        </select>

                        @error('tags')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary btn-lg w-100">Создать задачу</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
