@extends('layout')
@section('title','Фильмы')

@section('content')
    <h2 class="mb-3">Список фильмов</h2>

    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Длительность</th>
                <th>Ссылка</th>
            </tr>
            </thead>
            <tbody>
            @foreach($movies as $movie)
                <tr>
                    <td>{{ $movie->id }}</td>
                    <td>{{ $movie->name }}</td>
                    <td>{{ $movie->duration }} мин.</td>
                    <td><a class="btn btn-sm btn-outline-primary" href="{{ url('/movies/'.$movie->id) }}">Открыть</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
