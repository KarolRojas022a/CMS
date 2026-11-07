@extends('Layouts.app')

@section('title', 'Editar usuario')

@section('content')
<section class="container py-5">
    <div class="mb-4">
        <p class="section-kicker mb-2">Administración</p>
        <h1 class="h2 mb-1">Editar usuario</h1>
        <p class="text-secondary mb-0">{{ $user->email }}</p>
    </div>

    <div class="panel-card p-4 mb-4">
        <h2 class="h5 mb-3">Datos de la cuenta</h2>
        <form method="POST" action="{{ route('users.update', $user) }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label fw-semibold">Nombre</label>
                <input id="name" name="name" type="text" maxlength="100" required
                    class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}">
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label fw-semibold">Correo electrónico</label>
                <input id="email" name="email" type="email" maxlength="255" required
                    class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}">
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-4">
                <label for="role" class="form-label fw-semibold">Rol</label>
                <select id="role" name="role" required class="form-select @error('role') is-invalid @enderror">
                    <option value="editor" @selected(old('role', $user->role) === 'editor')>Editor</option>
                    <option value="admin" @selected(old('role', $user->role) === 'admin')>Administrador</option>
                </select>
                @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="d-flex flex-wrap gap-2">
                <button type="submit" class="btn btn-primary">Guardar cambios</button>
                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">Volver a usuarios</a>
            </div>
        </form>
    </div>

    <div class="panel-card p-4">
        <h2 class="h5 mb-1">Restablecer contraseña</h2>
        <p class="text-secondary">La nueva contraseña reemplazará la actual de inmediato.</p>
        <form method="POST" action="{{ route('users.password', $user) }}">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="password" class="form-label fw-semibold">Nueva contraseña</label>
                    <input id="password" name="password" type="password" minlength="8" required autocomplete="new-password"
                        class="form-control @error('password') is-invalid @enderror">
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-4">
                    <label for="password_confirmation" class="form-label fw-semibold">Confirmar contraseña</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" minlength="8" required autocomplete="new-password"
                        class="form-control">
                </div>
            </div>
            <button type="submit" class="btn btn-outline-primary">Restablecer contraseña</button>
        </form>
    </div>
</section>
@endsection
