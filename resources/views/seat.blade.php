<!doctype html>
<html lang="ru">
<head><meta charset="utf-8"><title>Место</title></head>
<body>
<h2>{{ $seat ? "Место ID ".$seat->id : "Неверный ID места" }}</h2>

@if($seat)
    <p>Зал: {{ $seat->hall->name ?? '-' }}</p>
    <p>Ряд: {{ $seat->row_num }}, Место: {{ $seat->seat_num }}</p>
    <p>Категория: {{ $seat->price_category }}</p>

    <h3>Сеансы, где это место было продано</h3>
    <table border="1">
        <tr><td>ID сеанса</td><td>Фильм</td><td>Начало</td><td>ФИО покупателя (pivot)</td></tr>
        @foreach($seat->seances as $seance)
            <tr>
                <td>{{ $seance->id }}</td>
                <td>{{ $seance->movie->name ?? '-' }}</td>
                <td>{{ $seance->start_at }}</td>
                <td>{{ $seance->pivot->full_name }}</td>
            </tr>
        @endforeach
    </table>
@endif
</body>
</html>
