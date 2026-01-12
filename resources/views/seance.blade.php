<!doctype html>
<html lang="ru">
<head><meta charset="utf-8"><title>Сеанс</title></head>
<body>
<h2>{{ $seance ? "Сеанс № ".$seance->id : "Неверный ID сеанса" }}</h2>

@if($seance)
    <p>Фильм: {{ $seance->movie->name ?? '-' }}</p>
    <p>Зал: {{ $seance->hall->name ?? '-' }}</p>
    <p>Начало: {{ $seance->start_at }}</p>

    <h3>Проданные места (через tickets)</h3>
    <table border="1">
        <tr><td>ID места</td><td>Ряд</td><td>Место</td><td>ФИО покупателя (pivot)</td></tr>
        @foreach($seance->seats as $seat)
            <tr>
                <td>{{ $seat->id }}</td>
                <td>{{ $seat->row_num }}</td>
                <td>{{ $seat->seat_num }}</td>
                <td>{{ $seat->pivot->full_name }}</td>
            </tr>
        @endforeach
    </table>
@endif
</body>
</html>

{{ $seances->links() }}
