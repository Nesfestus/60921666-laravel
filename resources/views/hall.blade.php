@extends('layout')
@section('title','Зал')

@section('content')
    <h2 class="mb-3">
        {{ $hall ? "Зал: ".$hall->name : "Неверный ID зала" }}
    </h2>

    @if($hall)
        <h4 class="mb-3">Места в зале</h4>

        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle">
                <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Ряд</th>
                    <th>Место</th>
                    <th>Категория</th>
                </tr>
                </thead>
                <tbody>
                @foreach($hall->seats as $seat)
                    <tr>
                        <td>{{ $seat->id }}</td>
                        <td>{{ $seat->row_num }}</td>
                        <td>{{ $seat->seat_num }}</td>
                        <td>{{ $seat->price_category }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <a class="btn btn-secondary" href="{{ url('/halls') }}">Назад</a>
    @endif
@endsection
