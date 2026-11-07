@extends('Layouts.app')

@section('title', 'Administrar usuarios')

@section('content')
<section class="container py-5">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3 mb-4">
        <div>
            <p class="section-kicker mb-2">Administración</p>
            <h1 class="h2 mb-1">Usuarios</h1>
            <p class="text-secondary mb-0">Crea cuentas, asigna roles y controla el acceso al CMS.</p>
        </div>
        <a href="{{ route('users.create') }}" class="btn btn-primary">Crear usuario</a>
    </div>

    <form method="GET" action="{{ route('users.index') }}" class="row g-2 mb-4">
        <div class="col-sm-8 col-md-6">
            <label for="search" class="visually-hidden">Buscar por nombre o correo</label>
            <input id="search" name="search" type="search" value="{{ $search }}" maxlength="100"
                class="form-control" placeholder="Buscar por nombre o correo">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-outline-primary">Buscar</button>
        </div>
        @if ($search !== '')
            <div class="col-auto">
                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">Limpiar</a>
            </div>
        @endif
    </form>

    <div class="panel-card overflow-hidden">
        @if ($users->isEmpty())
            <div class="p-4 text-secondary">No se encontraron usuarios.</div>
        @else
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="ps-4">Nombre</th>
                            <th scope="col">Correo</th>
                            <th scope="col">Rol</th>
                            <th scope="col">Estado</th>
                            <th scope="col" class="text-end pe-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <th scope="row" class="ps-4 fw-semibold">{{ $user->name }}</th>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->isAdmin() ? 'Administrador' : 'Editor' }}</td>
                                <td>{{ $user->is_active ? 'Activo' : 'Inactivo' }}</td>
                                <td class="text-end pe-4">
                                    <div class="d-inline-flex flex-wrap justify-content-end gap-2">
                                        <a href="{{ route('users.edit', $user) }}">Editar</a>
                                        @if (auth()->id() !== $user->id)
                                            <form method="POST" action="{{ route('users.status', $user) }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="is_active" value="{{ $user->is_active ? '0' : '1' }}">
                                                <button type="submit" class="btn btn-link p-0">
                                                    {{ $user->is_active ? 'Desactivar' : 'Activar' }}
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-3">{{ $users->links() }}</div>
        @endif
    </div>
</section>
@endsection
