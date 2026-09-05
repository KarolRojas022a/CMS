<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Requests\StorePostRequest;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    public function store(StorePostRequest $request)
    {
        $post = $request->user()->posts()->create(
            $request->validated()
        );

        return redirect()->route('posts.show', $post);
    }

    public function edit(Post $post)
    {
        Gate::authorize('update', $post);

        return view('posts.edit', compact('post'));
    }
}