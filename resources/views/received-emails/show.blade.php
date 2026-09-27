<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $email->subject ?: '(sin asunto)' }} | Buzón</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">Portal Seguro</a>
            <div class="d-flex align-items-center gap-3">
                <a class="btn btn-outline-light btn-sm" href="{{ route('received-emails.index') }}">Buzón de entrada</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">Cerrar sesión</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="container py-4 py-md-5">
        <a class="btn btn-link text-decoration-none px-0 mb-3" href="{{ route('received-emails.index') }}">
            &larr; Volver al buzón
        </a>

        <article class="card border-0 shadow-sm">
            <header class="card-header bg-white border-0 p-4 p-md-5 pb-3">
                <p class="text-uppercase text-secondary small fw-semibold mb-2">Correo recibido</p>
                <h1 class="h3 mb-4">{{ $email->subject ?: '(sin asunto)' }}</h1>
                <dl class="row mb-0 small">
                    <dt class="col-sm-2 text-secondary">De</dt>
                    <dd class="col-sm-10">{{ $email->from_name ?: $email->from_email }} &lt;{{ $email->from_email }}&gt;</dd>
                    <dt class="col-sm-2 text-secondary">Fecha</dt>
                    <dd class="col-sm-10 mb-0">{{ $email->received_at?->format('d/m/Y H:i') ?? 'Sin fecha' }}</dd>
                </dl>
            </header>
            <div class="card-body border-top p-4 p-md-5">
                <div class="text-break" style="white-space: pre-wrap;">{{ $email->body ?: '(sin contenido)' }}</div>
            </div>
        </article>
    </main>
</body>
</html>