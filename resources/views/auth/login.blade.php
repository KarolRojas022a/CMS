{{-- filepath: C:\xampp\htdocs\cms\resources\views\auth\login.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Iniciar sesión | Portal Seguro</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>
<body class="bg-light">

    <main class="min-vh-100 d-flex align-items-center py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-sm-10 col-md-7 col-lg-5 col-xl-4">

                    <div class="card border-0 shadow-lg rounded-4">
                        <div class="card-body p-4 p-md-5">

                            <div class="text-center mb-4">
                                <div
                                    class="bg-primary text-white rounded-circle
                                           d-inline-flex align-items-center
                                           justify-content-center mb-3"
                                    style="width: 64px; height: 64px;"
                                >
                                    🔐
                                </div>

                                <h1 class="h3 fw-bold text-dark mb-2">
                                    Iniciar sesión
                                </h1>

                                <p class="text-secondary mb-0">
                                    Accede al Portal Seguro
                                </p>
                            </div>

                            @if ($errors->any())
                                <div class="alert alert-danger" role="alert">
                                    <strong>No fue posible iniciar sesión.</strong>

                                    <ul class="mb-0 mt-2">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <form
                                method="POST"
                                action="{{ route('login.store') }}"
                            >
                                @csrf

                                <div class="mb-3">
                                    <label
                                        for="email"
                                        class="form-label fw-semibold"
                                    >
                                        Correo electrónico
                                    </label>

                                    <input
                                        id="email"
                                        type="email"
                                        name="email"
                                        value="{{ old('email') }}"
                                        class="form-control form-control-lg
                                            @error('email') is-invalid @enderror"
                                        placeholder="admin@gmail.com"
                                        autocomplete="username"
                                        required
                                        autofocus
                                    >

                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label
                                        for="password"
                                        class="form-label fw-semibold"
                                    >
                                        Contraseña
                                    </label>

                                    <div class="input-group input-group-lg">
                                        <input
                                            id="password"
                                            type="password"
                                            name="password"
                                            class="form-control
                                                @error('password') is-invalid @enderror"
                                            placeholder="Ingresa tu contraseña"
                                            autocomplete="current-password"
                                            required
                                        >

                                        <button
                                            id="togglePassword"
                                            class="btn btn-outline-secondary"
                                            type="button"
                                        >
                                            Mostrar
                                        </button>
                                    </div>

                                    @error('password')
                                        <div class="text-danger small mt-1">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-check mb-4">
                                    <input
                                        id="remember"
                                        type="checkbox"
                                        name="remember"
                                        value="1"
                                        class="form-check-input"
                                    >

                                    <label
                                        for="remember"
                                        class="form-check-label"
                                    >
                                        Recordarme
                                    </label>
                                </div>

                                <button
                                    type="submit"
                                    class="btn btn-primary btn-lg w-100 fw-semibold"
                                >
                                    Ingresar
                                </button>
                            </form>

                            <div class="text-center mt-4">
                                <a
                                    href="{{ route('pages.home') }}"
                                    class="text-decoration-none"
                                >
                                    ← Volver al inicio
                                </a>
                            </div>

                        </div>
                    </div>

                    <p class="text-center text-secondary small mt-4 mb-0">
                        © {{ date('Y') }} Portal Seguro
                    </p>

                </div>
            </div>
        </div>
    </main>

    <script>
        const passwordInput = document.getElementById('password');
        const togglePassword = document.getElementById('togglePassword');

        togglePassword.addEventListener('click', function () {
            const isPassword = passwordInput.type === 'password';

            passwordInput.type = isPassword ? 'text' : 'password';
            this.textContent = isPassword ? 'Ocultar' : 'Mostrar';
        });
    </script>
</body>
</html>