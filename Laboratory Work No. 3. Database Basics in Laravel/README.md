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
1. #### Создайте модель Category — категория задачи. Команда `php artisan make:model Category -m`
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

2. #### Определение структуры таблицы category в миграции:
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
3. #### Создайте модель Task — задача.
   Создадим модель Task:
   ```blade
   <?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Task extends Model
    {
        use HasFactory;

        public function category()
        {
           return $this->belongsTo(Category::class);
        }

        public function tags()
        {
            return $this->belongsToMany(Tag::class, 'task_tag');
        }
    }

   ```

4. #### Определение структуры таблицы task в миграции:
   - Добавьте поля:
      - id — первичный ключ;
      - title — название задачи;
      - description — описание задачи;
      - created_at — дата создания задачи;
      - updated_at — дата обновления задачи.

   ```blade 
    public function up(): void
    {
      Schema::create('tasks', function (Blueprint $table) {
      $table->id();
      $table->string('title');
      $table->text('description')->nullable();
      $table->timestamps();
      });
    }
   ```
5. #### Запустите миграцию для создания таблицы в базе данных: bash php artisan migrate
    Запустим команду `bash php artisan migrate` и посмотрим на содержимое нашей БД:
    !Картинка
6. #### Создайте модель Tag — тег задачи.
    ```blade 
     <?php

     namespace App\Models;

     use Illuminate\Database\Eloquent\Factories\HasFactory;
     use Illuminate\Database\Eloquent\Model;

     class Tag extends Model
     {
     use HasFactory;

     public function tasks()
     {
         return $this->belongsToMany(Task::class, 'task_tag');
     }
    }

   ```
    
7. #### Определение структуры таблицы tag в миграции:
  - Добавьте поля:
      - id — первичный ключ;
      - name — название тега;
      - created_at — дата создания тега;
      - updated_at — дата обновления тега.

    ```blade 
     public function up(): void
     {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
      }
    ```

8. #### Добавьте поле $fillable в модели Task, Category и Tag для массового заполнения данных.
    Для модели **Task** добавим следующую строку в определение класса: `protected $fillable = ['title', 'description', 'category_id'];` <br>
    Для модели **Category** добавим следующую строку в определение класса: `protected $fillable = ['name','description'];` <br>
    Для модели **Tag** добавим следующую строку в определение класса: `protected $fillable = ['name'];` <br>

### №3. Связь между таблицами
1. #### Создайте миграцию для добавления поля category_id в таблицу task.
    - php artisan make:migration add_category_id_to_tasks_table --table=tasks
    - Определите структуру поля category_id и добавьте внешний ключ для связи с таблицей category.
    
Пропишем указанную команду и получим следующий созданный файл, здесь же определим структуру полей и внешний ключ для связи с таблицей **category**
   ```blade 
   <?php

     use Illuminate\Database\Migrations\Migration;
     use Illuminate\Database\Schema\Blueprint;
     use Illuminate\Support\Facades\Schema;

     return new class extends Migration {
     public function up()
     {
            Schema::table('tasks', function (Blueprint $table) {
                $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
         });
     }

     public function down()
      {
           Schema::table('tasks', function (Blueprint $table) {
             $table->dropForeign(['category_id']);
             $table->dropColumn('category_id');
             });
     }
   };
   ```

2. #### Создайте промежуточную таблицу для связи многие ко многим между задачами и тегами:
    - php artisan make:migration create_task_tag_table
   
Cоздадим промежуточную таблицу при помощи команды `php artisan make:migration create_task_tag_table`
   

3. #### Определение соответствующей структуры таблицы в миграции.
    - Данная таблица должна связывать задачи и теги по их идентификаторам.
    - Например: task_id и tag_id: 10 задача связана с 5 тегом.
```blade 
    <?php

     use Illuminate\Database\Migrations\Migration;
     use Illuminate\Database\Schema\Blueprint;
     use Illuminate\Support\Facades\Schema;

     return new class extends Migration
     {
     public function up()
     {
      Schema::create('task_tag', function (Blueprint $table) {
      $table->id();
      $table->foreignId('task_id')->constrained('tasks')->onDelete('cascade');
      $table->foreignId('tag_id')->constrained('tags')->onDelete('cascade');
      $table->timestamps();
      });
     }

     public function down()
     {
         Schema::dropIfExists('task_tag');
     }
    };

   ```
4. #### Запустите миграцию для создания таблицы в базе данных.
Для запуска миграции нам понадобится применить команду `php artisan migrate
`