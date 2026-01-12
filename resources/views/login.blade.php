<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Вход</title>
    <style>.is-invalid{color:red;}</style>
</head>
<body>

@if($user)
    <h2>Здравствуйте, {{ $user->name }}</h2>
    <form method="post" action="{{ url('/logout') }}">
        @csrf
        <button type="submit">Выйти из системы</button>
    </form>
@else
    <h2>Вход в систему</h2>

    <form method="post" action="{{ url('/auth') }}">
        @csrf

        <label>E-mail</label><br>
        <input type="email" name="email" value="{{ old('email') }}"><br>
        @error('email')
        <div class="is-invalid">{{ $message }}</div>
        @enderror

        <br>

        <label>Пароль</label><br>
        <input type="password" name="password"><br>
        @error('password')
        <div class="is-invalid">{{ $message }}</div>
        @enderror

        <br>

        <input type="submit" value="Отправить">
    </form>

    @error('error')
    <div class="is-invalid">{{ $message }}</div>
    @enderror
@endif

</body>
</html>
