@extends('Layouts.app')

@section('title', 'Acerca')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="mb-3">Acerca del proyecto</h1>
            <p class="text-muted fs-5">
                CIUDADELA acerca la información institucional a la comunidad mediante
                un sitio público claro y un panel editorial de acceso restringido.
            </p>
            <hr class="my-4">
            <p>
                Las publicaciones se gestionan desde el panel institucional y permanecen
                como borradores hasta que una persona autorizada decide hacerlas públicas.
                El contenido se valida en el servidor y se presenta como texto seguro.
            </p>
            <p class="mb-0">
                Este alcance cubre el sitio público y la gestión editorial. No se almacenan
                expedientes de personas en riesgo en esta versión.
            </p>
        </div>
    </div>
</div>
@endsection