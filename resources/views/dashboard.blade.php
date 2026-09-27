{{-- filepath: C:\xampp\htdocs\cms\resources\views\dashboard.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Dashboard | Portal Seguro</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>
<body class="bg-light">
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('pages.home') }}">
                Portal Seguro
            </a>

            <a class="btn btn-outline-light me-auto ms-3" href="{{ route('received-emails.index') }}">
                Buzón de entrada
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit" class="btn btn-outline-light">
                    Cerrar sesión
                </button>
            </form>
        </div>
    </nav>

    <main class="container py-5">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-5">
                <h1 class="h3 mb-3">
                    Bienvenido, {{ auth()->user()->name }}
                </h1>

                <p class="text-secondary mb-0">
                    Has iniciado sesión correctamente en el Portal Seguro.
                </p>
            </div>
        </div>
    </main>
</body>
</html>