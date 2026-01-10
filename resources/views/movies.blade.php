<!doctype html>
<html lang="ru">
<head><meta charset="utf-8"><title>Фильмы</title></head>
<body>
<h2>Список фильмов</h2>

<table border="1">
    <tr><td>ID</td><td>Название</td><td>Длительность</td><td>Ссылка</td></tr>
    @foreach($movies as $movie)
        <tr>
            <td>{{ $movie->id }}</td>
            <td>{{ $movie->name }}</td>
            <td>{{ $movie->duration }}</td>
            <td><a href="/movies/{{ $movie->id }}">Открыть</a></td>
        </tr>
    @endforeach
</table>
</body>
</html>
