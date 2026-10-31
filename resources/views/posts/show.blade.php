@extends('Layouts.app')

@section('title', $post->title)
@section('meta_description', \Illuminate\Support\Str::limit($post->body, 155))

@section('content')
<article class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <a href="{{ route('pages.posts') }}" class="text-decoration-none">&larr; Todas las publicaciones</a>
            <header class="mt-4 mb-4">
                <p class="section-kicker mb-2">Información institucional</p>
                <h1 class="display-5 fw-bold">{{ $post->title }}</h1>
                <p class="text-secondary mb-0">
                    <time datetime="{{ $post->created_at->toDateString() }}">{{ $post->created_at->format('d/m/Y') }}</time>
                </p>
            </header>
            <div class="panel-card p-4 p-md-5 post-content">{{ $post->body }}</div>
        </div>
    </div>
</article>
@endsection
