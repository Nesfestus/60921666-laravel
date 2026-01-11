<!doctype html>
<html lang="ru">
<head><meta charset="utf-8"><title>Сеансы</title></head>
<body>

<h2>Список сеансов</h2>

<p><a href="/seances/create">Добавить сеанс</a></p>

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
                <a href="/seances/{{ $seance->id }}">Открыть</a>
                |
                <a href="/seances/edit/{{ $seance->id }}">Редактировать</a>
                |
                <a href="/seances/destroy/{{ $seance->id }}"
                   onclick="return confirm('Удалить сеанс №{{ $seance->id }}?');">
                    Удалить
                </a>
            </td>
        </tr>
    @endforeach
</table>

</body>
</html>
