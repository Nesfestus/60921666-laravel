<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Cinema')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light">

@include('partials.nav')
@include('partials.flash')

<main class="container py-4">
    @yield('content')
</main>

<footer class="border-top py-3 bg-white">
    <div class="container text-muted small">
        609-51м • Laravel • Cinema
    </div>
</footer>

</body>
</html>
