@extends('layouts.app')
@section('title', 'Publicaciones')
@section('content')
    <h1>Publicaciones</h1>

    <a href="{{ route('posts.create') }}">Nueva publicación</a>

    @foreach ($posts as $post)
        <div>
            <h3><a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a></h3>

            <form method="POST" action="{{ route('posts.destroy', $post) }}">
                @csrf
                @method('DELETE')
                <button>Eliminar</button>
            </form>
        </div>
    @endforeach
@endsection

