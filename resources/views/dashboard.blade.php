@extends('Layouts.app')

@section('title', 'Panel de gestión')

@section('content')
<section class="container py-5">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3 mb-4">
        <div>
            <p class="section-kicker mb-2">Área institucional</p>
            <h1 class="h2 mb-1">Hola, {{ auth()->user()->name }}</h1>
            <p class="text-secondary mb-0">Administra las publicaciones de la zona pública.</p>
        </div>
        <a href="{{ route('posts.create') }}" class="btn btn-primary">Crear publicación</a>
    </div>

    <div class="row g-3 mb-5">
        <div class="col-sm-4">
            <div class="panel-card p-4">
                <p class="text-secondary mb-1">Mis publicaciones</p>
                <p class="stat-value mb-0">{{ $postCount }}</p>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="panel-card p-4">
                <p class="text-secondary mb-1">Publicadas</p>
                <p class="stat-value mb-0">{{ $publishedCount }}</p>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="panel-card p-4">
                <p class="text-secondary mb-1">Borradores</p>
                <p class="stat-value mb-0">{{ $draftCount }}</p>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-3">
        <h2 class="h4 mb-0">Actividad reciente</h2>
        <div class="d-flex gap-3">
            <a href="{{ route('posts.index') }}">Gestionar publicaciones</a>
            <a href="{{ route('received-emails.index') }}">Buzón de entrada</a>
        </div>
    </div>

    <div class="panel-card overflow-hidden">
        @if ($recentPosts->isEmpty())
            <div class="p-4 text-secondary">Todavía no tienes publicaciones. Crea una para comenzar.</div>
        @else
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="ps-4">Título</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Última actualización</th>
                            <th scope="col" class="text-end pe-4">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recentPosts as $post)
                            <tr>
                                <th scope="row" class="ps-4 fw-semibold">{{ $post->title }}</th>
                                <td>
                                    <span class="badge rounded-pill {{ $post->is_published ? 'badge-published' : 'badge-draft' }}">
                                        {{ $post->is_published ? 'Publicada' : 'Borrador' }}
                                    </span>
                                </td>
                                <td>{{ $post->updated_at->format('d/m/Y') }}</td>
                                <td class="text-end pe-4"><a href="{{ route('posts.edit', $post) }}">Editar</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</section>
@endsection
