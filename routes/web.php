<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\DashboardController;

Route::get('/', [HomeController::class, 'index'])
    ->name('pages.home');

Route::get('/about', [HomeController::class, 'about'])
    ->name('pages.about');

Route::get('/contact', [HomeController::class, 'contact'])
    ->name('pages.contact');

Route::get('/posts/{post}', [PostController::class, 'show'])
    ->name('posts.show');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

    