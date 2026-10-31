@extends('Layouts.app')

@section('title', 'Gestionar publicaciones')

@section('content')
<section class="container py-5">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-end gap-3 mb-4">
        <div>
            <p class="section-kicker mb-2">Panel editorial</p>
            <h1 class="h2 mb-1">Mis publicaciones</h1>
            <p class="text-secondary mb-0">Los borradores no aparecen en el sitio público.</p>
        </div>
        <a href="{{ route('posts.create') }}" class="btn btn-primary">Crear publicación</a>
    </div>

    <div class="panel-card overflow-hidden">
        @if ($posts->isEmpty())
            <div class="p-4 p-md-5 text-center">
                <h2 class="h5">Aún no tienes publicaciones</h2>
                <p class="text-secondary">Crea un borrador y publícalo cuando esté listo.</p>
                <a href="{{ route('posts.create') }}" class="btn btn-primary">Crear primera publicación</a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="ps-4">Título</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Actualización</th>
                            <th scope="col" class="text-end pe-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($posts as $post)
                            <tr>
                                <th scope="row" class="ps-4 fw-semibold">{{ $post->title }}</th>
                                <td>
                                    <span class="badge rounded-pill {{ $post->is_published ? 'badge-published' : 'badge-draft' }}">
                                        {{ $post->is_published ? 'Publicada' : 'Borrador' }}
                                    </span>
                                </td>
                                <td>{{ $post->updated_at->format('d/m/Y') }}</td>
                                <td class="text-end pe-4 text-nowrap">
                                    <a class="me-3" href="{{ route('posts.edit', $post) }}">Editar</a>
                                    @if ($post->is_published)
                                        <a href="{{ route('posts.show', $post) }}">Ver</a>
                                    @endif
                                    <form
                                        class="d-inline ms-3"
                                        method="POST"
                                        action="{{ route('posts.destroy', $post) }}"
                                        onsubmit="return confirm('¿Eliminar esta publicación? Esta acción no se puede deshacer.');"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            class="btn btn-link text-danger p-0 align-baseline"
                                            aria-label="Eliminar {{ $post->title }}"
                                        >Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-3">{{ $posts->links() }}</div>
        @endif
    </div>
</section>
@endsection
