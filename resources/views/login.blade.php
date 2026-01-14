@extends('layout')

@section('title', 'Вход')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card card-body">

                @if($user)
                    <h2 class="h4 mb-3">Здравствуйте, {{ $user->name }}</h2>

                    <form method="post" action="{{ url('/logout') }}">
                        @csrf
                        <button class="btn btn-warning" type="submit">Выйти из системы</button>
                    </form>
                @else
                    <h2 class="h4 mb-3">Вход в систему</h2>

                    <form method="post" action="{{ url('/auth') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">E-mail</label>
                            <input class="form-control @error('email') is-invalid @enderror"
                                   type="email" name="email" value="{{ old('email') }}">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Пароль</label>
                            <input class="form-control @error('password') is-invalid @enderror"
                                   type="password" name="password">
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <button class="btn btn-success" type="submit">Войти</button>
                    </form>

                    @error('error')
                    <div class="alert alert-danger mt-3">{{ $message }}</div>
                    @enderror
                @endif

            </div>
        </div>
    </div>
@endsection
