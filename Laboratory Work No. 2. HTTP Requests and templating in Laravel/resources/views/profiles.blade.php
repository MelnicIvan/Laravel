<!-- resources/views/admin/profiles.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профили пользователей</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{asset('libs/bootstrap-reboot.min.css')}}">
    <link rel="stylesheet" href="{{asset('libs/bootstrap-grid.min.css')}}">
</head>
<body>
<div class="container">
    <h1 class="form-title">Профили пользователей</h1>

    <div class="row">
        @foreach($users as $user)
            <div class="col-md-4">
                <div class="profile-card">
                    <div class="profile-card-body">
                        <h3>{{ $user->name }}</h3>
                        <p>Email: {{ $user->email }}</p>
                        <p>Дата регистрации: {{ $user->created_at->format('d-m-Y') }}</p>
                        <a href="{{ route('profile', $user->id) }}" class="btn-view-profile">Просмотреть профиль</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<style>
    .profile-card {
        background-color: #f7f7f7;
        border: 1px solid #ddd;
        padding: 20px;
        margin-bottom: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    .profile-card h3 {
        color: #3a3a3a;
    }
    .profile-card p {
        font-size: 14px;
        color: #666;
    }
    .btn-view-profile {
        background-color: #007bff;
        color: white;
        padding: 10px 15px;
        text-decoration: none;
        border-radius: 5px;
    }
    .btn-view-profile:hover {
        background-color: #0056b3;
    }
</style>
</body>
</html>
