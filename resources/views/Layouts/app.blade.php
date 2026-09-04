
+<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Portal Seguro')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
          rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
          crossorigin="anonymous">

    <style>
        body {
            font-family: system-ui, -apple-system, "Segoe UI", sans-serif;
            background-color: #f8f9fa;
        }
        .navbar-brand {
            font-weight: 700;
            letter-spacing: .5px;
        }
        main {
            min-height: 70vh;
        }
        footer {
            background-color: #1b1b18;
            color: #cfcfcf;
        }
        footer a {
            color: #f8f9fa;
            text-decoration: none;
        }
        footer a:hover {
            color: #0d6efd;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ route('pages.home') }}">Portal Seguro</a>

                <button class="navbar-toggler" type="button"
                        data-bs-toggle="collapse" data-bs-target="#navbarMain"
                        aria-controls="navbarMain" aria-expanded="false"
                        aria-label="Alternar navegación">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarMain">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('pages.home') ? 'active fw-semibold' : '' }}"
                               href="{{ route('pages.home') }}">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('pages.about') ? 'active fw-semibold' : '' }}"
                               href="{{ route('pages.about') }}">Acerca</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('pages.contact') ? 'active fw-semibold' : '' }}"
                               href="{{ route('pages.contact') }}">Contacto</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="flex-grow-1">
        @if (session('status'))
            <div class="container mt-3">
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="py-4 mt-auto">
        <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center">
            <span>&copy; {{ date('Y') }} Portal Seguro. Todos los derechos reservados.</span>
            <div>
                <a href="{{ route('pages.about') }}" class="me-3">Acerca</a>
                <a href="{{ route('pages.contact') }}">Contacto</a>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
            crossorigin="anonymous"></script>
</body>
</html>



