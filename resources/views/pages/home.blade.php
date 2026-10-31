@extends('Layouts.app')

@section('title', 'Inicio')
@section('meta_description', 'Servicios, avisos y publicaciones institucionales de CIUDADELA.')

@section('content')
<section class="hero">
    <div class="container py-5 py-lg-6">
        <div class="row align-items-center min-vh-50">
            <div class="col-lg-8 hero-content py-4">
                <p class="eyebrow mb-3">Información pública · servicio a la comunidad</p>
                <h1 class="display-3 fw-bold mb-4">Una comunidad informada, una institución cercana.</h1>
                <p class="lead mb-4 col-xl-10">
                    Consulta avisos, publicaciones y canales de atención institucional en un espacio
                    abierto, claro y accesible.
                </p>
                <a class="btn btn-light btn-lg me-2 mb-2" href="{{ route('pages.posts') }}">Ver publicaciones</a>
                <a class="btn btn-outline-light btn-lg mb-2" href="{{ route('pages.contact') }}">Contactar</a>
            </div>
            <div class="col-lg-4 hero-content d-none d-lg-block">
                <div class="p-4 rounded-4 border border-light border-opacity-25 bg-white bg-opacity-10">
                    <p class="eyebrow mb-2">CIUDADELA</p>
                    <p class="h4 mb-0">Información pública con transparencia y respeto por las personas.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="container py-5" aria-labelledby="priorities-heading">
    <div class="row g-4">
        <div class="col-md-4">
            <article class="card feature-card">
                <div class="card-body p-4">
                    <p class="section-kicker mb-2">01 · Información</p>
                    <h2 class="h5">Contenido institucional claro</h2>
                    <p class="text-secondary mb-0">Avisos y publicaciones oficiales en un lugar fácil de consultar.</p>
                </div>
            </article>
        </div>
        <div class="col-md-4">
            <article class="card feature-card">
                <div class="card-body p-4">
                    <p class="section-kicker mb-2">02 · Acceso</p>
                    <h2 class="h5">Diseñado para todas las personas</h2>
                    <p class="text-secondary mb-0">Navegación adaptable, controles claros y soporte para teclado.</p>
                </div>
            </article>
        </div>
        <div class="col-md-4">
            <article class="card feature-card">
                <div class="card-body p-4">
                    <p class="section-kicker mb-2">03 · Confianza</p>
                    <h2 class="h5">Gestión institucional protegida</h2>
                    <p class="text-secondary mb-0">El panel editorial requiere una cuenta autorizada para ingresar.</p>
                </div>
            </article>
        </div>
    </div>
</section>

<section class="container pb-5" aria-labelledby="latest-heading">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-end gap-3 mb-4">
        <div>
            <p class="section-kicker mb-2">Actualidad</p>
            <h2 id="latest-heading" class="h2 mb-0">Últimas publicaciones</h2>
        </div>
        <a href="{{ route('pages.posts') }}" class="btn btn-outline-primary">Todas las publicaciones</a>
    </div>

    @if ($posts->isEmpty())
        <div class="panel-card p-4 p-md-5 text-center">
            <h3 class="h5">Próximamente habrá nuevas publicaciones</h3>
            <p class="text-secondary mb-0">Vuelve a consultar para conocer las novedades institucionales.</p>
        </div>
    @else
        <div class="row g-4">
            @foreach ($posts as $post)
                <div class="col-md-6 col-lg-4">
                    <article class="card post-card">
                        <div class="card-body p-4 d-flex flex-column">
                            <p class="small text-secondary mb-2">
                                <time datetime="{{ $post->created_at->toDateString() }}">{{ $post->created_at->format('d/m/Y') }}</time>
                            </p>
                            <h3 class="h5"><a class="text-decoration-none" href="{{ route('posts.show', $post) }}">{{ $post->title }}</a></h3>
                            <p class="text-secondary flex-grow-1">{{ \Illuminate\Support\Str::limit($post->body, 160) }}</p>
                            <a href="{{ route('posts.show', $post) }}" class="fw-semibold text-decoration-none">Leer publicación <span aria-hidden="true">→</span></a>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    @endif
</section>
@endsection
