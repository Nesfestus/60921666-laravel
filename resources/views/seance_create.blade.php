@extends('layout')

@section('title', 'Добавить сеанс')

@section('content')
    <h2 class="mb-3">Добавление сеанса</h2>

    <form class="card card-body" method="post" action="{{ url('/seances') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Зал</label>
            <select class="form-select @error('hall_id') is-invalid @enderror" name="hall_id">
                <option style="display:none"></option>
                @foreach($halls as $hall)
                    <option value="{{ $hall->id }}" @if(old('hall_id') == $hall->id) selected @endif>
                        {{ $hall->name }}
                    </option>
                @endforeach
            </select>
            @error('hall_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Фильм</label>
            <select class="form-select @error('movie_id') is-invalid @enderror" name="movie_id">
                <option style="display:none"></option>
                @foreach($movies as $movie)
                    <option value="{{ $movie->id }}" @if(old('movie_id') == $movie->id) selected @endif>
                        {{ $movie->name }}
                    </option>
                @endforeach
            </select>
            @error('movie_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Дата и время начала</label>
            <input class="form-control @error('start_at') is-invalid @enderror"
                   type="datetime-local" name="start_at" value="{{ old('start_at') }}">
            @error('start_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input @error('confirm') is-invalid @enderror"
                   type="checkbox" name="confirm" value="1" id="confirm" {{ old('confirm') ? 'checked' : '' }}>
            <label class="form-check-label" for="confirm">Подтверждаю создание сеанса</label>
            @error('confirm')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <button class="btn btn-primary" type="submit">Сохранить</button>
    </form>
@endsection
