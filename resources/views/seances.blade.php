@extends('layout')

@section('title', 'Сеансы')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="m-0">Список сеансов</h2>
        <a class="btn btn-primary" href="{{ url('/seances/create') }}">Добавить сеанс</a>
    </div>

    <form class="row g-2 align-items-center mb-3" method="get" action="{{ url('/seances') }}">
        <div class="col-auto">
            <label class="col-form-label">Элементов на странице:</label>
        </div>
        <div class="col-auto">
            <select class="form-select" name="perpage">
                <option value="2"  @if(($perpage ?? 5) == 2) selected @endif>2</option>
                <option value="5"  @if(($perpage ?? 5) == 5) selected @endif>5</option>
                <option value="10" @if(($perpage ?? 5) == 10) selected @endif>10</option>
                <option value="15" @if(($perpage ?? 5) == 15) selected @endif>15</option>
            </select>
        </div>
        <div class="col-auto">
            <button class="btn btn-outline-secondary" type="submit">Изменить</button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Зал</th>
                <th>Фильм</th>
                <th>Начало</th>
                <th style="width: 260px;">Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($seances as $seance)
                <tr>
                    <td>{{ $seance->id }}</td>
                    <td>{{ $seance->hall->name ?? $seance->hall_id }}</td>
                    <td>{{ $seance->movie->name ?? $seance->movie_id }}</td>
                    <td>{{ $seance->start_at }}</td>
                    <td>
                        <a class="btn btn-sm btn-outline-primary" href="{{ url('/seances/'.$seance->id) }}">Открыть</a>
                        <a class="btn btn-sm btn-outline-warning" href="{{ url('/seances/edit/'.$seance->id) }}">Редактировать</a>

                        <a class="btn btn-sm btn-outline-danger"
                           href="{{ url('/seances/destroy/'.$seance->id) }}"
                           onclick="return confirm('Удалить сеанс №{{ $seance->id }}?');">
                            Удалить
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    {{ $seances->links() }}
@endsection
