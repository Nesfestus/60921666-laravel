<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Редактировать сеанс</title>
    <style>.is-invalid{color:red;}</style>
</head>
<body>

<h2>Редактирование сеанса № {{ $seance->id }}</h2>

<form method="post" action="{{ url('/seances/update/'.$seance->id) }}">
    @csrf

    <label>Зал:</label><br>
    <select name="hall_id">
        <option style="display:none"></option>
        @foreach($halls as $hall)
            <option value="{{ $hall->id }}"
                    @if(old('hall_id', $seance->hall_id) == $hall->id) selected @endif>
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
                    @if(old('movie_id', $seance->movie_id) == $movie->id) selected @endif>
                {{ $movie->name }}
            </option>
        @endforeach
    </select>
    @error('movie_id')
    <div class="is-invalid">{{ $message }}</div>
    @enderror

    <br><br>

    <label>Дата и время начала:</label><br>
    <input type="datetime-local" name="start_at"
           value="{{ old('start_at') ? \Carbon\Carbon::parse(old('start_at'))->format('Y-m-d\TH:i')
                                : \Carbon\Carbon::parse($seance->start_at)->format('Y-m-d\TH:i') }}">

    @error('start_at')
    <div class="is-invalid">{{ $message }}</div>
    @enderror

    <br><br>

    <input type="submit" value="Сохранить изменения">
</form>

</body>
</html>
