@props(['priority'])

@if ($priority === 'Высокий')
    <span class="priority high" style="color: red;">&#x1F534; Высокий</span>
@elseif ($priority === 'Средний')
    <span class="priority medium" style="color: orange;">&#x1F7E0; Средний</span>
@elseif ($priority === 'Низкий')
    <span class="priority low" style="color: green;">&#x1F7E2; Низкий</span>
@endif
