@extends('Layouts.app')

@section('title', 'Nueva publicación')

@section('content')
<section class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <a href="{{ route('posts.index') }}" class="text-decoration-none">&larr; Volver a publicaciones</a>
            <div class="panel-card p-4 p-md-5 mt-3">
                <p class="section-kicker mb-2">Panel editorial</p>
                <h1 class="h2 mb-4">Nueva publicación</h1>

                <form method="POST" action="{{ route('posts.store') }}">
                    @csrf
                    @include('posts._form')
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
