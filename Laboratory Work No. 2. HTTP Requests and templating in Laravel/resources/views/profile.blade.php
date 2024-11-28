<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .profile-page {
            width: 100%;
            max-width: 600px; /* Уменьшаем ширину карточки */
            margin: 20px;
            padding: 20px;
            text-align: center;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }

        .profile-page:hover {
            transform: translateY(-5px);
        }

        .profile-info {
            margin-bottom: 30px;
        }

        .profile-info p {
            font-size: 1.1em;
            margin: 15px 0;
        }

        .profile-info strong {
            color: #2c3e50;
        }

        .btn-back-home {
            display: inline-block;
            padding: 10px 20px;
            background-color: #3498db;
            color: #fff;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease;
            width: 100%;
            text-align: center;
        }

        .btn-back-home:hover {
            background-color: #2980b9;
        }

        .container {
            width: 100%;
            display: flex;
            justify-content: center; /* Центрируем карточку */
            align-items: center;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="profile-page">
        <div class="profile-info">
            <p><strong>Имя:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Дата регистрации:</strong> {{ $user->created_at->format('d-m-Y') }}</p>
        </div>

        <!-- Кнопка для возвращения на главную страницу -->
        <a href="{{ url('/') }}" class="btn-back-home">Вернуться на главную</a>
    </div>
</div>
</body>
</html>
