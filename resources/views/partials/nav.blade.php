<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">Cinema</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCinema">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarCinema">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/halls') }}">Залы</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/movies') }}">Фильмы</a>
                </li>
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/seances') }}">Сеансы</a>
                    </li>
                @endauth
            </ul>

            {{-- Правая часть: вход/выход --}}
            @guest
                <form class="d-flex" method="post" action="{{ url('/auth') }}">
                    @csrf
                    <input class="form-control me-2 @error('email') is-invalid @enderror"
                           type="email" name="email" placeholder="E-mail" value="{{ old('email') }}">
                    <input class="form-control me-2 @error('password') is-invalid @enderror"
                           type="password" name="password" placeholder="Пароль">
                    <button class="btn btn-outline-success" type="submit">Войти</button>
                </form>
            @else
                <span class="navbar-text text-white me-3">
                    {{ Auth::user()->name }}
                </span>
                <form method="post" action="{{ url('/logout') }}">
                    @csrf
                    <button class="btn btn-outline-warning" type="submit">Выйти</button>
                </form>
            @endguest
        </div>
    </div>
</nav>
