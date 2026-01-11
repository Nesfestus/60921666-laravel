<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Создать сеанс</title>
    <style>.is-invalid{color:red;}</style>
</head>
<body>

<h2>Добавление сеанса</h2>

<form method="post" action="{{ url('/seances') }}">
    @csrf

    <label>Зал:</label><br>
    <select name="hall_id">
        <option style="display:none"></option>
        @foreach($halls as $hall)
            <option value="{{ $hall->id }}"
                    @if(old('hall_id') == $hall->id) selected @endif>
                {{ $hall->name }}
            </option>
        @endforeach
    </select>
    @error('hall_id')
    <div class="is-invalid">{{ $message }}</div>
    @enderror

    <br><br>

    <label>Фильм:</label><br>
    <select name="movie_id">
        <option style="display:none"></option>
        @foreach($movies as $movie)
            <option value="{{ $movie->id }}"
                    @if(old('movie_id') == $movie->id) selected @endif>
                {{ $movie->name }}
            </option>
        @endforeach
    </select>
    @error('movie_id')
    <div class="is-invalid">{{ $message }}</div>
    @enderror

    <br><br>

    <label>Дата и время начала:</label><br>
    <input type="datetime-local" name="start_at" value="{{ old('start_at') }}">
    @error('start_at')
    <div class="is-invalid">{{ $message }}</div>
    @enderror

    <br><br>

    <label>
        <input type="checkbox" name="confirm" value="1" {{ old('confirm') ? 'checked' : '' }}>
        Подтверждаю создание сеанса
    </label>
    @error('confirm')
    <div class="is-invalid">{{ $message }}</div>
    @enderror

    <br><br>

    <input type="submit" value="Сохранить">
</form>

</body>
</html>
