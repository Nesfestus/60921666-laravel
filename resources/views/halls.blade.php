@extends('layout')
@section('title','Залы')

@section('content')
    <h2 class="mb-3">Список залов</h2>

    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Наименование</th>
                <th>Ссылка</th>
            </tr>
            </thead>
            <tbody>
            @foreach($halls as $hall)
                <tr>
                    <td>{{ $hall->id }}</td>
                    <td>{{ $hall->name }}</td>
                    <td><a class="btn btn-sm btn-outline-primary" href="{{ url('/halls/'.$hall->id) }}">Открыть</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
