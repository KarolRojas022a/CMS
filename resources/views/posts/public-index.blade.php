@extends('Layouts.app')

@section('title', 'Publicaciones')
@section('meta_description', 'Avisos y publicaciones institucionales de CIUDADELA.')

@section('content')
<section class="container py-5">
    <header class="mb-5">
        <p class="section-kicker mb-2">Información institucional</p>
        <h1 class="display-5 fw-bold">Publicaciones</h1>
        <p class="lead text-secondary mb-0">Avisos y novedades disponibles para toda la comunidad.</p>
    </header>

    @if ($posts->isEmpty())
        <div class="panel-card p-4 p-md-5 text-center">
            <h2 class="h5">No hay publicaciones disponibles</h2>
            <p class="text-secondary mb-0">Vuelve pronto para consultar las novedades institucionales.</p>
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
                            <h2 class="h5"><a class="text-decoration-none" href="{{ route('posts.show', $post) }}">{{ $post->title }}</a></h2>
                            <p class="text-secondary flex-grow-1">{{ \Illuminate\Support\Str::limit($post->body, 180) }}</p>
                            <a href="{{ route('posts.show', $post) }}" class="fw-semibold text-decoration-none">Leer publicación <span aria-hidden="true">→</span></a>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
        <div class="mt-4">{{ $posts->links() }}</div>
    @endif
</section>
@endsection
