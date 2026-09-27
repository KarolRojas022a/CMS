<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Buzón de entrada | Portal Seguro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">Portal Seguro</a>
            <div class="d-flex align-items-center gap-3">
                <a class="btn btn-outline-light btn-sm" href="{{ route('dashboard') }}">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">Cerrar sesión</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="container py-4 py-md-5">
        <div class="d-flex flex-wrap align-items-start justify-content-between gap-3 mb-4">
            <div>
                <p class="text-uppercase text-secondary small fw-semibold mb-1">Mensajes recibidos</p>
                <h1 class="h2 mb-0">Buzón de entrada</h1>
            </div>
            <span class="badge text-bg-primary rounded-pill px-3 py-2">
                {{ $unreadCount }} sin leer
            </span>
        </div>

        <section class="card border-0 shadow-sm" aria-label="Correos recibidos">
            @if ($emails->isEmpty())
                <div class="card-body py-5 text-center">
                    <h2 class="h5">Todavía no hay correos</h2>
                    <p class="text-secondary mb-0">Los mensajes importados desde el buzón aparecerán aquí.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" class="ps-4">Remitente</th>
                                <th scope="col">Asunto y mensaje</th>
                                <th scope="col" class="text-nowrap">Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($emails as $receivedEmail)
                                <tr class="{{ $receivedEmail->is_read ? '' : 'table-primary' }}">
                                    <td class="ps-4" style="min-width: 190px">
                                        <a class="text-reset text-decoration-none {{ $receivedEmail->is_read ? '' : 'fw-bold' }}"
                                           href="{{ route('received-emails.show', $receivedEmail) }}">
                                            {{ $receivedEmail->from_name ?: $receivedEmail->from_email }}
                                        </a>
                                        @if ($receivedEmail->from_name)
                                            <div class="small text-secondary">{{ $receivedEmail->from_email }}</div>
                                        @endif
                                    </td>
                                    <td style="min-width: 240px">
                                        <a class="text-reset text-decoration-none" href="{{ route('received-emails.show', $receivedEmail) }}">
                                            <span class="d-block {{ $receivedEmail->is_read ? 'fw-medium' : 'fw-bold' }}">
                                                {{ $receivedEmail->subject ?: '(sin asunto)' }}
                                            </span>
                                            <span class="small text-secondary">
                                                {{ Illuminate\Support\Str::limit(strip_tags($receivedEmail->body ?? ''), 140) }}
                                            </span>
                                        </a>
                                    </td>
                                    <td class="text-secondary small text-nowrap">
                                        {{ $receivedEmail->received_at?->format('d/m/Y H:i') ?? 'Sin fecha' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if ($emails->hasPages())
                    <div class="card-footer bg-white border-0 px-4 py-3">
                        {{ $emails->links() }}
                    </div>
                @endif
            @endif
        </section>
    </main>
</body>
</html>