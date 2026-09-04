@extends('layouts.app')

@section('title', 'Acerca')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="mb-3">Acerca del proyecto</h1>
            <p class="text-muted fs-5">
                Este sitio aplica prácticas de desarrollo seguro como parte del
                Campo de Aprendizaje Disciplinar "Desarrollo de Software Seguro".
            </p>
            <hr class="my-4">
            <p>
                Fue construido con <strong>Laravel</strong>, siguiendo el ciclo
                Plan → Code → Build → Test → Deploy → Operate, incorporando
                controles de seguridad desde etapas tempranas (Shift Left).
            </p>
        </div>
    </div>
</div>
@endsection