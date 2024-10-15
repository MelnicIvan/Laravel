## Лабораторная работа №3. Основы работы с базами данных в Laravel

### №1. Подготовка к работе
1. #### Установите СУБД MySQL, PostgreSQL или SQLite на вашем компьютере.
   В данной лабораторной работе будет использоваться **PostgreSQL**. Для этого в **Docker'e** запустим контейнер, который будет использовать **Image PostgreSQL**. После создания контейнера подключимся к нему.  
2. #### Создание базы данных: Создайте новую базу данных для вашего приложения todo_app.
3. #### Настройте переменные окружения в файле .env для подключения к базе данных: env DB_CONNECTION=ваша_бд (mysql, pgsql, sqlite) DB_HOST=127.0.0.1 DB_PORT=3306 DB_DATABASE=todo_app DB_USERNAME=ваш_пользователь DB_PASSWORD=ваш_пароль
```blade
DB_CONNECTION=pgsql
DB_HOST=localhost
DB_PORT=5432
DB_DATABASE=todo_db
DB_USERNAME=ivan
DB_PASSWORD=...
```

### №2. Создание моделей и миграций
  1. Создайте модель Category — категория задачи. Команда `php artisan make:model Category -m`
     При помощи вышеуказанной команды создадим модель **Category**.
     ```blade
      <?php

      namespace App\Models;

      use Illuminate\Database\Eloquent\Factories\HasFactory;
      use Illuminate\Database\Eloquent\Model;

      class Category extends Model
      {
       use HasFactory;

       public function tasks()
       {
        return $this->hasMany(Task::class);
       }
      }

       ```
  3. Определение структуры таблицы category в миграции:
     - Добавьте поля:
        - id — первичный ключ;
        - name — название категории;
        - description — описание категории;
        - created_at — дата создания категории;
        - updated_at — дата обновления категории.
  
  В файле миграций create_categories_table, добавим следующий код, который будет описывать структуру таблицы:
  ```blade
    public function up(): void
    {
      Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }
  ```
  4. Создайте модель Task — задача.
  5. Определение структуры таблицы task в миграции:
     - Добавьте поля:
        - id — первичный ключ;
        - title — название задачи;
        - description — описание задачи;
        - created_at — дата создания задачи;
        - updated_at — дата обновления задачи.
  6. Запустите миграцию для создания таблицы в базе данных: bash php artisan migrate
  7. Создайте модель Tag — тег задачи.
  8. Определение структуры таблицы tag в миграции:
    - Добавьте поля:
        - id — первичный ключ;
        - name — название тега;
        - created_at — дата создания тега;
        - updated_at — дата обновления тега.
  9. Добавьте поле $fillable в модели Task, Category и Tag для массового заполнения данных.
