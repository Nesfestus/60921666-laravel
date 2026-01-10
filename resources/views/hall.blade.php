<!doctype html>
<html lang="ru">
<head><meta charset="utf-8"><title>Зал</title></head>
<body>
<h2>
    {{ $hall ? "Зал: ".$hall->name : "Неверный ID зала" }}
</h2>

@if($hall)
    <h3>Места в зале</h3>
    <table border="1">
        <tr><td>ID</td><td>Ряд</td><td>Место</td><td>Категория</td></tr>
        @foreach($hall->seats as $seat)
            <tr>
                <td>{{ $seat->id }}</td>
                <td>{{ $seat->row_num }}</td>
                <td>{{ $seat->seat_num }}</td>
                <td>{{ $seat->price_category }}</td>
            </tr>
        @endforeach
    </table>
@endif
</body>
</html>
