## Лабораторная работа №5. Компоненты безопасности в Laravel

### №1. Подготовка к работе
В данной лабораторной работе будет использован проект из предыдущих лабораторных работ. Изменения будут вноситься поверх уже созданного функционала. Необходимые переменные в `.env` файле будут проинициализированы необходимыми значениями для успешного подключения к базе данных.

### №2. Аутентификация пользователей
  **1.** Создадим контроллер AuthController для управления аутентификацией пользователей. Для этого используем команду `php artisan make:controller AuthController`.

  **2.** Создадим и добавим реализацию для методов регистрации, входа и выхода пользователя.
  - register() для отображения формы регистрации
   ```php
    public function register()
    {
      return view('auth.register');
    }
   ```
  - storeRegister() для обработки данных формы регистрации.
   ```php
    public function storeRegister(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('login')->with('success', 'Вы успешно зарегистрировались!');
    }
   ```
  - login() для отображения формы входа.
   ```php
    public function login()
    {
        return view('auth.login');
    }
   ```
  - storeLogin() для обработки данных формы входа.
   ```php
    public function storeLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('dashboard')->with('success', 'Вы успешно вошли в систему!');
        }

        return back()->withErrors([
            'email' => 'Неверные учетные данные.',
        ]);
    }
   ```
  **3.** Создадим маршруты для регистрации, входа и выхода пользователя, для этого в файле `routes/web.php` добавим маршруты:
  ```php
   use App\Http\Controllers\AuthController;

   Route::get('/register', [AuthController::class, 'register'])->name('register');
   Route::post('/register', [AuthController::class, 'storeRegister']);

   Route::get('/login', [AuthController::class, 'login'])->name('login');
   Route::post('/login', [AuthController::class, 'storeLogin']);

   Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
  ```
  **4.** Обновим представления для форм регистрации и входа:

 Напишем код для страницы с формой логина:
  ```blade
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

  ```

Напишем код для страницы с формой регистрации:
```blade
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

```

**5.** Создадим отдельный класс Request для валидации данных при регистрации и входе, для этого используем команды: `php artisan make:request LoginRequest` и  `php artisan make:request RegisterRequest`

Добавим следующее содержимое в `LoginRequest`:
```php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Поле "Email" обязательно для заполнения.',
            'email.email' => 'Некорректный формат email.',
            'password.required' => 'Поле "Пароль" обязательно для заполнения.',
        ];
    }
}

```

Также добавим содержимое в `RegisterRequest`:
```php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Поле "Имя" обязательно для заполнения.',
            'email.required' => 'Поле "Email" обязательно для заполнения.',
            'email.email' => 'Некорректный формат email.',
            'email.unique' => 'Такой email уже используется.',
            'password.required' => 'Поле "Пароль" обязательно для заполнения.',
            'password.min' => 'Пароль должен быть не менее 8 символов.',
            'password.confirmed' => 'Пароли не совпадают.',
        ];
    }
}

```

**6.** Выполним проверку функционала логина и регистрации. введем валидные данные в форму регистрации, отправим данные на сервер и посмотрим результат:

![{B809E72E-D82D-409E-A944-27711B31AC79}](https://github.com/user-attachments/assets/a44a1a2b-089e-4dbb-bbf2-b06c039c15ad)

После нажатия на кнопку "Зарегистрироваться", пользователь попадает на страницу "Логин":

![{9B342C18-4254-48CA-998B-38F1CEDB95B7}](https://github.com/user-attachments/assets/1fa550b2-5961-4c37-8952-87dad8e2cd99)

Удостоверимся в том, что `user` действительно добавился в базу данных, для этого посмотрим содержимое таблицы `users`:

![{97902543-0B07-43A2-96A0-F8D99982F301}](https://github.com/user-attachments/assets/a24a8db6-d596-4325-ae7f-5a9461bc9a3d)

Теперь проверим корректность работы функционала "Аутентификации" пользователя, введем ранее зарегистрированные креденциалы пользователя и нажмем кнопку "Войти":

![{B9E58449-76AA-422E-8D75-1F16934990B2}](https://github.com/user-attachments/assets/bc10d132-c7a1-4dd0-bda3-b0a465f5d021)

Как видно пользователь был перенаправлен на главную страницу приложения: 

![{77D16596-15E0-4F00-96EE-FA361805FF98}](https://github.com/user-attachments/assets/10bf0fc4-008d-4390-b765-abb198f7af26)

### №3. Авторизация пользователей.

**1.** Добавим функционал авторизации пользователей, сделаем так, чтобы к страницам приложения имели доступ только авторизованные пользователи

**2.** Настроим проверку доступа к страницам, добавив middleware auth к необходимым маршрутам.
```php
Route::middleware(['auth'])->group(function () {
    Route::get('/about', [HomeController::class, 'about'])->name('about');
    Route::get('/', [HomeController::class, 'index'])->name('home');
});
```

**3.** Проверим добавленный функционал, действительно ли теперь доступ к указанным маршрутам есть только у авторизованных пользователей. Введем в url-строку защищенный маршрут и попробуем перейти на указанную страницу:

![{251F10DE-7B70-42C0-8B71-9853BB23DB9C}](https://github.com/user-attachments/assets/c5f7bac9-33ff-4e02-815b-0905e4fa8dbc) 

Нажмем "Enter" и посмотрим результат:

![{14B5A839-B67E-451F-AAC6-FC9D274328EA}](https://github.com/user-attachments/assets/d965727b-5291-4d74-b9bd-3b2233ef4a0e)

Как видно, у пользователя не получилось перейти на указанную страницу и поэтому он остался на странице "Логин"

### №4. Роли пользователей

**1.** Добавим систему ролей Админиcтратор и Пользователь. Для этого необходимо создать миграцию для добавления колонки в таблицу user, которая будет отвечать за роль пользователя. После того, как была добавлена новая колонка,  можно создать два метода для проверки роли у сущности User:
```php
   public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isUser()
    {
        return $this->role === 'user';
    }
```

**2.** Следующим шагом добавим возможность для админа просматривать все профили пользователей, а пользователю добавим возможность просматривать информацию о своем профиле. Для реализации этой задачи были созданы две отдельные страницы, одна будет отображать все карточки профилей пользователей и доступ к ней будет только у админа, а другая будет отвечать за информацию о конкретном профиле пользователя. Вот как выглядит авнель навигации для админа:

![{53BA3CB3-9651-4896-8A31-F27A7F32E39B}](https://github.com/user-attachments/assets/433bb7b8-0a14-404d-aa0c-e1a6358c3f84)

Как видно на рисунке, у админа в панели присутствует кнопка "Просмотр профилей", у пользователя с ролью `user` такой кнопки нет, есть только кнопка для просмотра своего профиля:

![{F8CB1478-B8BE-4058-80AD-74DF488AEE0D}](https://github.com/user-attachments/assets/406d8a16-7cc8-4232-829f-447e42ac1caf)

**3.** Теперь реализуем проверки ролей, чтобы обеспечить корреектное распределение прав доступа. Для этого в файле `web.php` пропишем `middleware` с необходимыми нам маршрутами. `Middleware` будет ограничивать доступ к маршрутам в зависимости от роли пользователя.
```php
Route::middleware(['auth'])->group(function () {
    Route::get('/about', [HomeController::class, 'about'])->name('about');
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

    Route::get('/admin/profiles', [ProfileController::class, 'adminProfiles'])->middleware('role:admin');
});

Route::middleware(['auth', 'can:viewAny,App\Models\User'])->group(function () {
    Route::get('/admin/profiles', [ProfileController::class, 'adminProfiles'])->name('admin.profiles');
});

```

### №5. Выход и защита от CSRF

**1.** Добавим кнопку выхода для пользователя. Для этого в `AuthController` пропишем реализацию метода `logout`:
```php
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Вы успешно вышли из системы.');
    }
```
И на главную страницу добавим кнопку, которая будет активировать этот метод:

![{C63062ED-98DB-46B2-8252-4D95BB713C23}](https://github.com/user-attachments/assets/4a600ae7-7a36-4df8-a985-287b55a5ca60)

Теперь при нажатии на кнопку "Выйти" пользователь будет перенаправлен на страницу "Логин".

**2.** Для обеспечения безопасности форм, необходимо добавить защиту от CSRF атак, поэтому во всех созданных формах добавим аннотацию `@csrf`, которая обеспечит соответствующую безопасность:
```php
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
```

**3.** Проверим правильность работы выхода пользователя из аккаунта, попробуем нажать на кнопку "Выйти" и посмотрим, что произойдет:

![{EA163B4B-BA58-4295-84EE-82FF7710FDC6}](https://github.com/user-attachments/assets/8b08bb31-043a-4ca2-9c74-5929fd099c44)

После того, как пользователя нажал на кнопку "Выйти", он был перенаправлен на страницу "Логин", а его текущая сессия завершилась. Таким образом можно сказать, что выход пользователя из системы прошел успешно и безопасно.

## <center>Контрольные вопросы</center>
1. #### Какие готовые решения для аутентификации предоставляет Laravel?
Laravel предоставляет несколько встроенных решений для аутентификации, включая систему регистрации, входа и выхода пользователей. Основные функции Laravel для аутентификации включают:
  - Laravel Breeze: Легковесное решение, которое предоставляет минимальную настройку для аутентификации, включая регистрацию, вход, сброс пароля и проверку email.
  - Laravel Jetstream: Более полное решение для аутентификации, включающее функции двухфакторной аутентификации, управления сессиями, профилями пользователей, а также API-систему на базе 
  - Laravel Sanctum для работы с токенами.
  - Laravel Fortify: Бэкенд для аутентификации, который можно интегрировать с любым фронтенд-фреймворком. Это позволяет реализовать кастомные интерфейсы для аутентификации.
  - Laravel Passport: Для создания полноценной OAuth2 аутентификации, когда необходимо создать API, работающие с токенами.

Эти решения предоставляют готовые маршруты и методы для регистрации пользователей, входа, выхода, сброса паролей и других стандартных операций.

2. #### Какие методы аутентификации пользователей вы знаете?
В Laravel поддерживаются несколько методов аутентификации пользователей:
  - Сессии (Session-Based Authentication): Стандартный метод аутентификации в Laravel, при котором данные о пользователе хранятся в сессии. Это подходит для традиционных веб-приложений.
  - Токены (Token-Based Authentication): Используется, например, с Laravel Passport или Laravel Sanctum для работы с API, где пользователь получает токен, который отправляется с каждым   
    запросом.
  - Двухфакторная аутентификация (2FA): Дополнительный уровень безопасности, который требует от пользователя ввода одноразового кода, отправленного через SMS или приложение.
  - OAuth: Используется для аутентификации через внешние сервисы, такие как Google, Facebook или GitHub, с помощью Laravel Socialite.
  - API-аутентификация с помощью Laravel Sanctum: Этот метод предназначен для работы с API, позволяя пользователям аутентифицироваться с использованием cookie или токенов.

3. #### Чем отличается аутентификация от авторизации?
**Аутентификация** — это процесс проверки, кто является пользователем. Это начальный шаг в системе безопасности, который подтверждает, что предоставленные учетные данные (например, логин и пароль) принадлежат именно тому пользователю, который пытается войти в систему.

**Авторизация** — это процесс определения, какие действия или ресурсы доступны пользователю после успешной аутентификации. После того как система удостоверилась, кто этот пользователь, авторизация решает, какие действия он может выполнять: например, может ли он просматривать страницы, редактировать их или удалять.

Пример: Аутентификация — это когда система проверяет ваши данные (логин/пароль), а авторизация — это когда система решает, можно ли вам редактировать профиль.

4. #### Как обеспечить защиту от CSRF-атак в Laravel?
В Laravel защита от CSRF-атак обеспечивается автоматически с помощью встроенного middleware VerifyCsrfToken. Каждая форма, отправляющая POST-запросы, должна включать уникальный CSRF-токен, который генерируется и хранится в сессии пользователя. Этот токен добавляется в каждую форму через директиву @csrf. При отправке формы сервер проверяет, соответствует ли отправленный токен тому, что хранится в сессии. Если токен не совпадает или отсутствует, запрос отклоняется. Также можно исключить определенные маршруты от проверки CSRF, настроив массив $except в middleware, например для API-запросов. Это позволяет эффективно защищать приложение от атак типа CSRF, предотвращая подделку запросов с другого сайта.
