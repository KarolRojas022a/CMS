<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CIUDADELA') · CIUDADELA</title>
    <meta name="description" content="@yield('meta_description', 'Información y servicios públicos de CIUDADELA.')">
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous"
    >
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="d-flex flex-column min-vh-100">
    <a class="skip-link" href="#main-content">Saltar al contenido principal</a>

    <header>
        <nav class="navbar navbar-expand-lg navbar-dark site-navbar">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('pages.home') }}">
                    <span class="brand-mark" aria-hidden="true">C</span>
                    <span>CIUDADELA</span>
                </a>
                <button
                    class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarMain"
                    aria-controls="navbarMain"
                    aria-expanded="false"
                    aria-label="Alternar navegación"
                >
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarMain">
                    <ul class="navbar-nav ms-auto align-items-lg-center">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('pages.home') ? 'active fw-semibold' : '' }}" href="{{ route('pages.home') }}">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('pages.posts', 'posts.show') ? 'active fw-semibold' : '' }}" href="{{ route('pages.posts') }}">Publicaciones</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('pages.about') ? 'active fw-semibold' : '' }}" href="{{ route('pages.about') }}">Acerca</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('pages.contact') ? 'active fw-semibold' : '' }}" href="{{ route('pages.contact') }}">Contacto</a>
                        </li>
                        @auth
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('dashboard', 'posts.*', 'received-emails.*', 'users.*') ? 'active fw-semibold' : '' }}" href="{{ route('dashboard') }}">Panel de gestión</a>
                            </li>
                            <li class="nav-item d-flex align-items-center ms-lg-2">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-light">Cerrar sesión</button>
                                </form>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Acceso institucional</a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main id="main-content" class="flex-grow-1">
        @if (session('status'))
            <div class="container mt-3">
                <div class="alert alert-success" role="status">{{ session('status') }}</div>
            </div>
        @endif
        @if (session('error'))
            <div class="container mt-3">
                <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
            </div>
        @endif
        @if ($errors->any())
            <div class="container mt-3">
                <div class="alert alert-danger" role="alert">
                    <p class="fw-semibold mb-1">Revisa los datos ingresados:</p>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        @yield('content')
    </main>

    <footer class="site-footer py-4 mt-auto">
        <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center">
            <span>&copy; {{ date('Y') }} CIUDADELA · Información pública para todas las personas.</span>
            <div>
                <a href="{{ route('pages.about') }}" class="me-3">Acerca</a>
                <a href="{{ route('pages.contact') }}">Contacto</a>
            </div>
        </div>
    </footer>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"
    ></script>
    @stack('scripts')
</body>
</html>
