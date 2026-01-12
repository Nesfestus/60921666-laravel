<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Ошибка доступа</title>
</head>
<body>
<h2>{{ $message ?? 'Ошибка доступа' }}</h2>
<p><a href="{{ url('/seances') }}">Назад</a></p>
</body>
</html>
