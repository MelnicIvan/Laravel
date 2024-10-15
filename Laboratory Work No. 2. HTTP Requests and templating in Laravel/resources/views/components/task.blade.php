@props(['task'])

<div class="task">
    <h2>{{ $task['title'] }}</h2>
    <p>{{ $task['description'] }}</p>
    <p><strong>Дата создания:</strong> {{ $task['created_at'] }}</p>
    <p><strong>Дата обновления:</strong> {{ $task['updated_at'] }}</p>

    <div class="actions">
        <a class="redo-btn" href="{{ route('tasks.edit', $task['id']) }}">Редактировать</a>
        <form action="{{ route('tasks.destroy', $task['id']) }}" method="POST" style="display:inline-block;">
            @csrf
            @method('DELETE')
            <button class="del-btn" type="submit" onclick="return confirm('Вы уверены?')">Удалить</button>
        </form>
    </div>
</div>


