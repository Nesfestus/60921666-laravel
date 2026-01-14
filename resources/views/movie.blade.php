@extends('layout')
@section('title','Фильм')

@section('content')
    <h2 class="mb-3">
        {{ $movie ? "Фильм: ".$movie->name : "Неверный ID фильма" }}
    </h2>

    @if($movie)
        <p class="text-muted">Длительность: {{ $movie->duration }} мин.</p>

        <h4 class="mb-3">Сеансы фильма</h4>

        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle">
                <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Зал</th>
                    <th>Начало</th>
                </tr>
                </thead>
                <tbody>
                @foreach($movie->seances as $seance)
                    <tr>
                        <td>{{ $seance->id }}</td>
                        <td>{{ $seance->hall_id }}</td>
                        <td>{{ $seance->start_at }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <a class="btn btn-secondary" href="{{ url('/movies') }}">Назад</a>
    @endif
@endsection
