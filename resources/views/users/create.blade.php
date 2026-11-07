@extends('Layouts.app')

@section('title', 'Crear usuario')

@section('content')
<section class="container py-5">
    <div class="mb-4">
        <p class="section-kicker mb-2">Administración</p>
        <h1 class="h2 mb-1">Crear usuario</h1>
        <p class="text-secondary mb-0">La cuenta se creará activa y podrá iniciar sesión de inmediato.</p>
    </div>

    <div class="panel-card p-4">
        <form method="POST" action="{{ route('users.store') }}">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label fw-semibold">Nombre</label>
                <input id="name" name="name" type="text" maxlength="100" required
                    class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label fw-semibold">Correo electrónico</label>
                <input id="email" name="email" type="email" maxlength="255" required
                    class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="role" class="form-label fw-semibold">Rol</label>
                <select id="role" name="role" required class="form-select @error('role') is-invalid @enderror">
                    <option value="editor" @selected(old('role', 'editor') === 'editor')>Editor</option>
                    <option value="admin" @selected(old('role') === 'admin')>Administrador</option>
                </select>
                <div class="form-text">Los administradores pueden gestionar usuarios y todas las publicaciones.</div>
                @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="password" class="form-label fw-semibold">Contraseña</label>
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

            <div class="d-flex flex-wrap gap-2">
                <button type="submit" class="btn btn-primary">Crear usuario</button>
                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</section>
@endsection
