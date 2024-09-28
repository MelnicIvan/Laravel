@extends('layouts.app')

@section('title', 'Главная')

@section('header', 'Добро пожаловать в To-Do App для команд')

@section('content')
    <header class="header">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 header-content">
                    <h1>Начни планировать свой день прямо сейчас!</h1>
                    <h4>И подстрой время под себя</h4>
                    <a class="btn-main" href="{{ route('tasks.index') }}">Список задач</a>
                </div>
            </div>
        </div>
        <div class="overlay"></div>
    </header>

    @if(isset($lastTask))
        <h2 class="last-task-title">Последняя созданная задача</h2>
        <x-task :task="$lastTask"/>
    @else
        <p>Нет задач для отображения</p>
    @endif
@endsection
