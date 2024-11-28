## Лабораторная работа №4. Формы и валидация данных

### №1. Подготовка к работе
В данной лабораторной работе будет использован проект из предыдущих лабораторных работ. Изменения будут вноситься поверх уже созданного функционала. Необходимые переменные в `.env` файле будут проинициализированы необходимыми значениями для успешного подключения к базе данных.

### №2. Создание формы
**2.1-2.2** Форма должна содержать следующие поля: Название, Описание, Дата выполнения, Категория.
   Для того чтобы реализовать добавление новой задачи путем выполнения запроса через форму, необходимо обновить существующий код формы и добавить соответствующие поля, в данном случае необходимо добавить поле, которое отвечает за дату выполнения задачи. Здесь же   
   осуществим рендеринг формы при помощи `blade`-шаблонов:
```blade
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
                        <label for="due_date" class="form-label">Дата выполнения</label>
                        <input type="date" name="due_date" id="due_date" class="form-control" required value="{{ old('due_date') }}">
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
```
**2.3.** Поле Категория должно быть выпадающим списком, загруженным из таблицы категорий в базе данных.
   Для реализации этой задачи будем в цикле перебирать все существующие задачи из таблицы категорий и отразим полученный результат на странице: <br><br>
   ![{059D4BD3-7CF2-4651-8FCA-99BE7CAC1F20}](https://github.com/user-attachments/assets/caf1970f-b71e-46b3-999c-01653afa7aa8) <br><br>
**2.4.** Обеспечьте, чтобы форма отправляла данные методом POST на маршрут, созданный для обработки данных.
   Для того, чтобы осуществить отправку данных из формы по соответствующему типу запроса, укажем значение `POST` в атрибутах формы и также укажем путь к методу, который будет обрабатывать форму:
   ```blade
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
   ```
**2.5** Также обновим контроллер `TaskController`, который должен содержать методы `store` и `create` для успешной обработки формы:
```php
class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with(['category', 'tags'])->get();
        return view('tasks.index', ['tasks' => $tasks]);
    }

    public function home()
    {
        $lastTask = Task::latest()->first();
        return view('home', compact('lastTask'));
    }


    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('tasks.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date|after_or_equal:today',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        $task = Task::create($validated);

        if ($request->has('tags')) {
            $task->tags()->sync($request->input('tags'));
        }

        return redirect()->route('tasks.index')->with('success', 'Задача успешно создана!');
    }
```
### №3. Валидация данных на стороне сервера 
**3.1** Реализуйте валидацию данных непосредственно в методе `store` контроллера `TaskControlle`r. 
При помощи функции `validat`e зададим необходимые нам параметры, которым должны удовлетворять полученные данные с формы. Вот как будет выглядеть обновленный метод `store`: 
```php
public function store(Request $request)
    {
        // Валидация данных из формы
        $validated = $request->validate([
            'title' => 'required|string|min:3|max:255',
            'description' => 'nullable|string|max:500',
            'due_date' => 'required|date|after_or_equal:today',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id', 
        ]);

        $task = Task::create($validated);

        if ($request->has('tags')) {
            $task->tags()->sync($request->input('tags'));
        }

        return redirect()->route('tasks.index')->with('success', 'Задача успешно создана!');
    }
```
**3.2** Внесем изменения в код формы, чтобы при неправильномм вводе пользователя сервер оповещал его о том, что необходимо ввести данные в правильном формате:
```blade
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
```
**3.3** После того, как форма была отправлена, необходимо обработать ошибки валидации и вернуть их обратно к форме, а также отобразить соответствующие ошибки рядом с полями.
```blade
 <div class="mb-4">
    <label for="title" class="form-label">Название</label>
    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" required value="{{ old('title') }}" placeholder="Введите название задачи">
    @error('title')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
```
**3.4** Проверим корректность работы внедренного функционала валидации:
Попробуем ввести в поле "название задачи" текст, длиной меньше, чем 3 символа <br><br>
 ![{26528224-C413-40BE-B85F-027C733DE76B}](https://github.com/user-attachments/assets/8d33e8af-a77a-4ddd-8f8a-5d07adc9322a) <br><br>
 Как видно на рисунке выше в ответе от сервера, было получено сообщение о том, что название задачи должно состоять минимум из трех символов.

### №4. Создание собственного класса запроса (Request)
**4.1** Используя команду `php artisan make:request CreateTaskRequest`

**4.2** В классе `CreateTaskRequest` определим правила валидации, аналогичные тем, что были в контроллере `TaskController`:
```php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTaskRequest extends FormRequest
{
    /**
     * Определяем, авторизован ли пользователь для выполнения этого запроса.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // разрешаем все пользователи, в зависимости от требований можно добавить проверки на авторизацию
    }

    /**
     * Получаем правила валидации, которые должны быть применены к данным запроса.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|min:3|max:255', // обязательное поле, строка, минимальная длина 3 символа
            'description' => 'nullable|string|max:500', // необязательное поле, строка, максимальная длина 500 символов
            'due_date' => 'required|date|after_or_equal:today', // обязательная дата, не меньше сегодняшней
            'category_id' => 'required|exists:categories,id', // обязательное поле, должно быть существующим id категории
            'tags' => 'nullable|array', // необязательное поле, массив тегов
            'tags.*' => 'exists:tags,id', // каждый тег должен существовать в таблице tags
        ];
    }

    /**
     * Получаем сообщения об ошибках для пользовательских атрибутов.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => 'Название задачи обязательно.',
            'title.min' => 'Название должно содержать минимум 3 символа.',
            'due_date.after_or_equal' => 'Дата выполнения не может быть раньше сегодняшнего дня.',
            'category_id.exists' => 'Выбранная категория не существует.',
            'tags.*.exists' => 'Один или несколько тегов не существуют.',
        ];
    }
}
```
**4.3** Следующим шагом, необходимо обновить метод `store` контроллера `TaskControlle`r для использования созданного `CreateTaskRequest` вместо стандартного Request.
```php
public function store(CreateTaskRequest $request) // используем CreateTaskRequest
    {
        $validated = $request->validated();

        $task = Task::create($validated);

        if ($request->has('tags')) {
            $task->tags()->sync($request->input('tags'));
        }

        return redirect()->route('tasks.index')->with('success', 'Задача успешно создана!');
    }
```
**4.4** Чтобы удостовериться в том, что `category_id` действительно существует в базе данных и оно принадлежит определенной категории, используем слудующую функцию:
```php
public function rules()
    {
        return [
            'title' => 'required|string|min:3|max:255', // обязательное поле, строка, минимальная длина 3 символа
            'description' => 'nullable|string|max:500', // необязательное поле, строка, максимальная длина 500 символов
            'due_date' => 'required|date|after_or_equal:today', // обязательная дата, не меньше сегодняшней
            'category_id' => 'required|exists:categories,id', // обязательное поле, должно быть существующим id категории
            'tags' => 'nullable|array', // необязательное поле, массив тегов
            'tags.*' => 'exists:tags,id', // каждый тег должен существовать в таблице tags
        ];
    }
```
Как видно для поля `category_id` проверяется, что `id` действительно существует.

**4.5** Теперь убедимся, что возможные ошибки при введении данных в форму корректно обрабатываются сервером: <br><br>
 ![{76D37667-651F-482C-971A-8400CF0F21CC}](https://github.com/user-attachments/assets/244d247d-3345-4d22-97d6-a5f1c0f20aba) <br><br>
 Как видно на картинке проверка введенной даты сработала успешно и сервер не позволил нам создать задачу, срок выполнения которой является прошедшей датой.

### №5. Добавление флеш-сообщений
**5.1** Обновим главный `blade` шаблон таким образом, чтобы после добавления новой задачи, сервер перенаправлял пользователя на страницу со всеми задачами и выводил влеш-сообщение о том, что задача была успешно добавлена или, в случае ошибки, сообщение о том, что произошла ошибка.
```blade
@extends('layouts.app')
@section('content')
    <div class="container mt-4">
        <!-- Флеш-сообщение об успешном сохранении или ошибке -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="background-color: #28a745; color: white; border-left: 5px solid #218838; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                <strong>Успех!</strong> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="color: white;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="background-color: #dc3545; color: white; border-left: 5px solid #c82333; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                <strong>Ошибка!</strong> {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="color: white;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="table-responsive">
            <table class="table todo-table">
                <thead>
                <tr class="todo-table-header">
                    <th style="text-align: center">Название</th>
                    <th style="text-align: center">Описание</th>
                    <th style="text-align: center">Дата выполнения</th>
                    <th>Категория</th>
                    <th style="text-align: center">Теги</th>
                </tr>
                </thead>
                <tbody>
                @foreach($tasks as $task)
                    <tr class="todo-table-row">
                        <td>
                            <a class="task-link" href="{{ route('tasks.show', $task->id) }}">{{ $task->title }}</a>
                        </td>
                        <td>{{ Str::limit($task->description, 100) }}</td>
                        <td>{{ $task->due_date }}</td>
                        <td>{{ $task->category->name }}</td>
                        <td>
                            @foreach($task->tags as $tag)
                                <span class="badge bg-secondary">{{ $tag->name }},</span>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
```
**5.2** Также необходимо обновить метод `store` контроллера `TaskController`, чтобы флеш-сообщения успешно появлялись при успешном сохранении задачи:
```php
 public function store(CreateTaskRequest $request)
    {
        $validated = $request->validated();

        $task = Task::create($validated);

        if ($request->has('tags')) {
            $task->tags()->sync($request->input('tags'));
        }

        return redirect()->route('tasks.index')->with('success', 'Задача успешно создана!');
    }
```

### №6. Защита от CSRF
**6.1** Чтобы обеспечить безопасность данных в формах и защитить от атак `CSRF (Cross-Site Request Forgery)`, необходимо добавить директиву `@csrf` в форму, а также убедиться, что форма использует метод `POST` для отправки данных.
Добавим аннотацию `@csrf` после объявления формы, чтобы защитить форму от `CSRF` атак:
```blade
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
```

### №7. Обновление задачи
**7.1** Первым делом, необходимо создать форму для обновления задачи, которая будет содержать все необходимые поля, которые возможно обновить у задачи:
```blade
@extends('layouts.app')
@section('content')
    <div class="container mt-4 d-flex justify-content-center">
        <div class="card shadow-lg" style="width: 100%; max-width: 800px; border-radius: 15px; overflow: hidden;">
            <div class="card-header bg-gradient text-white">
                <h4 class="mb-0 text-center">Редактировать задачу</h4>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="title" class="form-label">Название</label>
                        <input type="text" name="title" id="title" class="form-control" value="{{ $task->title }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="description" class="form-label">Описание</label>
                        <textarea name="description" id="description" class="form-control" rows="4" required>{{ $task->description }}</textarea>
                    </div>
                    <div class="mb-4">
                        <label for="category_id" class="form-label">Категория</label>
                        <select name="category_id" id="category_id" class="form-select" required>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ $task->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="tags" class="form-label">Теги</label>
                        <select name="tags[]" id="tags" class="form-select" multiple>
                            @foreach ($tags as $tag)
                                <option value="{{ $tag->id }}" {{ in_array($tag->id, $task->tags->pluck('id')->toArray()) ? 'selected' : '' }}>
                                    {{ $tag->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-warning btn-lg">Обновить задачу</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
```
**7.2** При помощи команды `php artisan make:request UpdateTaskRequest` создадим новый `Request`-класс с правилами, которые определены для валидации данных при создании задачи:
**7.3** Создадим маршрут `GET /tasks/{task}/edit`, и метод `edit` в контроллере TaskController.
```php
Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
```
```php
public function edit($id)
    {
        $task = Task::findOrFail($id);
        $categories = Category::all();
        $tags = Tag::all();

        return view('tasks.edit', compact('task', 'categories', 'tags'));
    }
```
**7.4** Создадим маршрут `PUT /tasks/{task}` для обновления задачи:
```php
Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
```
**7.5** Обновим метод `update` в контроллере `TaskController` для обработки данных из формы:
```php
public function update(UpdateTaskRequest $request, $id)
    {
        $validated = $request->validated();

        $task = Task::findOrFail($id);

        $task->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'due_date' => $validated['due_date'],
            'category_id' => $validated['category_id'],
        ]);

        // Обновляем теги (синхронизируем)
        if ($request->has('tags')) {
            $task->tags()->sync($request->input('tags'));
        }

        return redirect()->route('tasks.show', $task->id)->with('success', 'Задача успешно обновлена!');
    }
```

## <center>Контрольные вопросы</center>
1. #### Что такое валидация данных и зачем она нужна?
    - Валидация данных — это процесс проверки, соответствует ли введенная пользователем информация заданным правилам (например, типу данных, минимальной/максимальной длине, формату и т. д.). В `Laravel` валидация помогает убедиться, что данные, полученные из формы, соответствуют требованиям, прежде         чем они будут сохранены в базе данных.
    - Зачем она нужна? Валидация необходима для предотвращения ошибок, обеспечения целостности данных и защиты от атак (например, инъекций или неправильных данных). Она также помогает улучшить пользовательский опыт, показывая корректные сообщения об ошибках при вводе неверных данных.
2. #### Как обеспечить защиту формы от `CSRF`-атак в `Laravel`?
    - `Laravel` автоматически защищает от `CSRF`-атак (`Cross-Site Request Forgery`), используя токены безопасности. Для защиты формы нужно добавить директиву `@csrf` в форму. Это гарантирует, что запросы, отправленные с вашего сайта, будут проверяться на наличие правильного `CSRF`-токена.
    - Пример
      ```blade
      @csrf
      <button type="submit">Отправить</button>
      </form>
      ```
3. #### Как создать и использовать собственные классы запросов (`Request`) в `Laravel`?
   - Для создания собственного класса запроса в Laravel используется команда:
     ```php
      php artisan make:request UpdateTaskRequest
     ```
   - Внутри этого класса определяются правила валидации, которые будут использоваться в контроллере. Класс может также содержать логику авторизации и условия, при которых запрос будет разрешен.
   - Пример использования:
     ```php
     use App\Http\Requests\UpdateTaskRequest;

      public function update(UpdateTaskRequest $request, $id)
      {
      $validated = $request->validated();
      }
     ```
4. #### Как защитить данные от `XSS`-атак при выводе в представлении?
   - Для защиты от `XSS`-атак (`Cross-Site Scripting`) при выводе данных в представлениях, `Laravel` автоматически экранирует данные, выводимые через `Blade`-шаблоны. Это предотвращает выполнение опасного `JavaScript`-кода, который может быть внедрен через пользовательский ввод.
   - Пример защиты:
     ```blade
      <h1>{{ $task->title }}</h1>  <!-- Данные экранируются автоматически -->
     ```
   - Для вывода необработанных данных (если это необходимо), можно использовать {!! !!}:
     ```blade
      <h1>{!! $task->description !!}</h1>  <!-- Будьте осторожны, данные могут быть не экранированы -->
     ```
     Но это следует использовать только с доверенными данными, чтобы избежать `XSS`-атак.
