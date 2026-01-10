<!doctype html>
<html lang="ru">
<head><meta charset="utf-8"><title>Фильм</title></head>
<body>
<h2>
    {{ $movie ? "Фильм: ".$movie->name : "Неверный ID фильма" }}
</h2>

@if($movie)
    <p>Длительность: {{ $movie->duration }} мин.</p>

    <h3>Сеансы фильма</h3>
    <table border="1">
        <tr><td>ID</td><td>Зал</td><td>Начало</td></tr>
        @foreach($movie->seances as $seance)
            <tr>
                <td>{{ $seance->id }}</td>
                <td>{{ $seance->hall_id }}</td>
                <td>{{ $seance->start_at }}</td>
            </tr>
        @endforeach
    </table>
@endif
</body>
</html>
