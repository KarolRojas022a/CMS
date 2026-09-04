@extends('layouts.app')

@section('title', 'Inicio')

@section('content')
<section class="bg-primary bg-gradient text-white py-5">
    <div class="container py-5 text-center">
        <h1 class="display-4 fw-bold">Portal Seguro</h1>
        <p class="lead col-lg-8 mx-auto">
            Un sitio construido con seguridad desde el diseño: validación en el
            servidor, protección CSRF y buenas prácticas DevSecOps desde el primer commit.
        </p>
        <a href="{{ route('pages.contact') }}" class="btn btn-light btn-lg mt-2">
            Contáctanos
        </a>
    </div>
</section>

<section class="container py-5">
    <div class="row g-4 text-center">
        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title">🔒 Seguridad primero</h5>
                    <p class="card-text text-muted">
                        Validación de entradas, CSRF y sesiones protegidas en cada ruta.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title">⚙️ DevSecOps</h5>
                    <p class="card-text text-muted">
                        Los controles de seguridad viven en el flujo, no al final.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title">🧩 Laravel 13</h5>
                    <p class="card-text text-muted">
                        Rutas nombradas, controladores limpios y layouts reutilizables.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

