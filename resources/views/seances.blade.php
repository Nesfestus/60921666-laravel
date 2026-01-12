<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Сеансы</title>
</head>
<body>

<h2>Список сеансов</h2>

<p><a href="/seances/create">Добавить сеанс</a></p>

<form method="get" action="{{ url('/seances') }}">
    <label>Элементов на странице:</label>
    <select name="perpage">
        <option value="2"  @if(($perpage ?? 5) == 2) selected @endif>2</option>
        <option value="5"  @if(($perpage ?? 5) == 5) selected @endif>5</option>
        <option value="10" @if(($perpage ?? 5) == 10) selected @endif>10</option>
        <option value="15" @if(($perpage ?? 5) == 15) selected @endif>15</option>
    </select>
    <input type="submit" value="Изменить">
</form>

<br>

<table border="1">
    <tr>
        <td>ID</td>
        <td>Зал</td>
        <td>Фильм</td>
        <td>Начало</td>
        <td>Действия</td>
    </tr>

    @foreach($seances as $seance)
        <tr>
            <td>{{ $seance->id }}</td>
            <td>{{ $seance->hall->name ?? $seance->hall_id }}</td>
            <td>{{ $seance->movie->name ?? $seance->movie_id }}</td>
            <td>{{ $seance->start_at }}</td>
            <td>
                <a href="/seances/{{ $seance->id }}">Открыть</a> |
                <a href="/seances/edit/{{ $seance->id }}">Редактировать</a> |
                <a href="/seances/destroy/{{ $seance->id }}"
                   onclick="return confirm('Удалить сеанс №{{ $seance->id }}?');">
                    Удалить
                </a>
            </td>
        </tr>
    @endforeach
</table>

<br>

{{ $seances->links() }}

</body>
</html>
