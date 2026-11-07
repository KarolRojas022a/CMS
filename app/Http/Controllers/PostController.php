<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class PostController extends Controller
{
    public function publicIndex(): View
    {
        return view('posts.public-index', [
            'posts' => Post::query()
                ->published()
                ->latest()
                ->paginate(9),
        ]);
    }

    public function index(): View
    {
        $posts = auth()->user()->isAdmin()
            ? Post::query()
            : auth()->user()->posts();

        return view('posts.index', [
            'posts' => $posts->latest()->paginate(10),
        ]);
    }

    public function create(): View
    {
        Gate::authorize('create', Post::class);

        return view('posts.create');
    }

    public function store(StorePostRequest $request)
    {
        $post = $request->user()->posts()->create(
            [
                ...$request->validated(),
                'is_published' => $request->boolean('is_published'),
            ]
        );

        return redirect()
            ->route('posts.edit', $post)
            ->with('status', 'La publicación se guardó correctamente.');
    }

    public function show(Post $post): View
    {
        abort_unless($post->is_published, 404);

        return view('posts.show', compact('post'));
    }

    public function edit(Post $post): View
    {
        Gate::authorize('update', $post);

        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post): RedirectResponse
    {
        Gate::authorize('update', $post);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'body' => ['required', 'string', 'max:10000'],
            'is_published' => ['sometimes', 'boolean'],
        ]);

        $post->update([
            ...$validated,
            'is_published' => $request->boolean('is_published'),
        ]);

        return redirect()
            ->route('posts.edit', $post)
            ->with('status', 'Los cambios se guardaron correctamente.');
    }

    public function destroy(Post $post): RedirectResponse
    {
        Gate::authorize('delete', $post);
        $post->delete();

        return redirect()
            ->route('posts.index')
            ->with('status', 'La publicación se eliminó correctamente.');
    }
}
