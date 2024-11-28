<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<div class="container">
    <h1 class="form-title">Вход</h1>
    <form method="POST" action="{{ route('login') }}" class="form-login">
        @csrf

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required class="input-field">
            @error('email') <p class="error-message">{{ $message }}</p> @enderror
        </div>

        <div class="form-group">
            <label for="password">Пароль</label>
            <input type="password" id="password" name="password" required class="input-field">
            @error('password') <p class="error-message">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="btn-submit">Войти</button>
    </form>

    <div class="register-link">
        <p>Нет аккаунта?</p>
        <a href="{{ route('register') }}" class="btn-register">Зарегистрироваться</a>
    </div>
</div>
</body>
</html>
