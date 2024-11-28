<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<div class="container">
    <h1 class="form-title">Регистрация</h1>
    <form method="POST" action="{{ route('register') }}" class="form-register">
        @csrf

        <div class="form-group">
            <label for="name">Имя</label>
            <input type="text" id="name" name="name" required class="input-field">
            @error('name') <p class="error-message">{{ $message }}</p> @enderror
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required class="input-field">
            @error('email') <p class="error-message">{{ $message }}</p> @enderror
        </div>

        <div class="form-group">
            <label for="password">Пароль</label>
            <input type="password" id="password" name="password" required class="input-field">
            @error('password') <p class="password-error-message">{{ $message }}</p> @enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation">Подтверждение пароля</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required class="input-field">
        </div>

        <button type="submit" class="btn-submit">Зарегистрироваться</button>
    </form>

    <div class="login-link">
        <p>Уже есть аккаунт?</p>
        <a href="{{ route('login') }}" class="btn-login">Войти</a>
    </div>
</div>
</body>
</html>
