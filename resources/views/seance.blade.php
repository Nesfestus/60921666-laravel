@extends('layout')
@section('title','Сеанс')

@section('content')
    <h2 class="mb-3">{{ $seance ? "Сеанс № ".$seance->id : "Неверный ID сеанса" }}</h2>

    @if($seance)
        <div class="card card-body mb-3">
            <p class="mb-1"><b>Фильм:</b> {{ $seance->movie->name ?? '-' }}</p>
            <p class="mb-1"><b>Зал:</b> {{ $seance->hall->name ?? '-' }}</p>
            <p class="mb-0"><b>Начало:</b> {{ $seance->start_at }}</p>
        </div>

        <h4 class="mb-3">Проданные места (tickets)</h4>

        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle">
                <thead class="table-dark">
                <tr>
                    <th>ID места</th>
                    <th>Ряд</th>
                    <th>Место</th>
                    <th>ФИО покупателя</th>
                </tr>
                </thead>
                <tbody>
                @foreach($seance->seats as $seat)
                    <tr>
                        <td>{{ $seat->id }}</td>
                        <td>{{ $seat->row_num }}</td>
                        <td>{{ $seat->seat_num }}</td>
                        <td>{{ $seat->pivot->full_name }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <a class="btn btn-secondary" href="{{ url('/seances') }}">Назад</a>
    @endif
@endsection
