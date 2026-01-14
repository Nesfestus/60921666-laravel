@extends('layout')

@section('title', 'Ошибка доступа')

@section('content')
    <div class="alert alert-danger">
        {{ $message ?? 'Ошибка доступа' }}
    </div>

    <a class="btn btn-secondary" href="{{ url('/seances') }}">Назад</a>
@endsection
