@extends('Layouts.app')

@section('title', 'Acceso institucional')

@section('content')
<section class="container py-5">
    <div class="row justify-content-center">
        <div class="col-sm-10 col-md-7 col-lg-5">
            <div class="panel-card p-4 p-md-5">
                <p class="section-kicker mb-2">Área institucional</p>
                <h1 class="h2 mb-2">Acceso institucional</h1>
                <p class="text-secondary mb-4">Ingresa con tu cuenta autorizada para gestionar el contenido público.</p>

                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <p class="fw-semibold mb-1">No fue posible iniciar sesión.</p>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('status'))
                    <div class="alert alert-success" role="status">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ route('login.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">Correo electrónico</label>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="form-control form-control-lg @error('email') is-invalid @enderror"
                            autocomplete="username"
                            maxlength="255"
                            required
                            autofocus
                        >
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">Contraseña</label>
                        <div class="input-group input-group-lg">
                            <input
                                id="password"
                                type="password"
                                name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                autocomplete="current-password"
                                required
                            >
                            <button
                                id="togglePassword"
                                class="btn btn-outline-secondary"
                                type="button"
                                aria-label="Mostrar contraseña"
                                aria-pressed="false"
                            >Mostrar</button>
                        </div>
                        @error('password')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-check mb-4">
                        <input id="remember" type="checkbox" name="remember" value="1" class="form-check-input">
                        <label for="remember" class="form-check-label">Mantener sesión iniciada</label>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-100">Ingresar</button>
                </form>

                <p class="text-secondary small mt-4 mb-0">
                    Este acceso es únicamente para personal institucional autorizado.
                </p>
            </div>
        </div>
    </div>
</section>
@endsection
