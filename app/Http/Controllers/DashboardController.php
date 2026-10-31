<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $posts = auth()->user()->posts();

        return view('dashboard', [
            'postCount' => (clone $posts)->count(),
            'publishedCount' => (clone $posts)->where('is_published', true)->count(),
            'draftCount' => (clone $posts)->where('is_published', false)->count(),
            'recentPosts' => (clone $posts)->latest()->take(5)->get(),
        ]);
    }
}
