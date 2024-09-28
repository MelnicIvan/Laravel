<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - ToDo Everyday</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{asset('libs/bootstrap-reboot.min.css')}}">
    <link rel="stylesheet" href="{{asset('libs/bootstrap-grid.min.css')}}">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,400;0,700;1,400&display=swap"
          rel="stylesheet">

</head>
<body>

<nav class="navbar">
    <div class="container">
        <x-header :title="'To-Do for You'"/>
        <div class="navbar-wrap">
            <ul class="navbar-menu">
                <li><a href="{{ url('/') }}">Главная</a></li>
                <li><a href="{{ route('tasks.index') }}">Список задач</a></li>
                <li><a href="{{ url('/about') }}">О нас</a></li>
            </ul>

            <a href="{{ route('tasks.create') }}" class="callback">Создать задачу</a>
        </div>
    </div>

</nav>

<div class="content">
    @yield('content')
</div>

</body>
</html>


