<!doctype html>
<html lang="ru">
<head><meta charset="utf-8"><title>Залы</title></head>
<body>
<h2>Список залов</h2>

<table border="1">
    <tr><td>ID</td><td>Наименование</td><td>Ссылка</td></tr>
    @foreach($halls as $hall)
        <tr>
            <td>{{ $hall->id }}</td>
            <td>{{ $hall->name }}</td>
            <td><a href="/halls/{{ $hall->id }}">Открыть</a></td>
        </tr>
    @endforeach
</table>
</body>
</html>
<?php
