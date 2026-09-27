<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ReceivedEmailController;

// ---------- Rutas públicas ----------
Route::get('/', [HomeController::class, 'index'])
    ->name('pages.home');

Route::get('/about', [HomeController::class, 'about'])
    ->name('pages.about');

Route::get('/contact', [HomeController::class, 'contact'])
    ->name('pages.contact');

Route::get('/posts/{post}', [PostController::class, 'show'])
    ->name('posts.show');

Route::get('/contacto', [ContactController::class, 'create'])
    ->name('contact.create');

Route::post('/contacto', [ContactController::class, 'store'])
    ->middleware('throttle:contact')
     ->name('contact.store');

// ---------- Autenticación (solo invitados) ----------
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'store'])
        ->middleware('throttle:login')
        ->name('login.store');
});

// ---------- Zona protegida (solo autenticados) ----------
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/dashboard/received-emails', [ReceivedEmailController::class, 'index'])
        ->name('received-emails.index');

    Route::get('/dashboard/received-emails/{receivedEmail}', [ReceivedEmailController::class, 'show'])
        ->name('received-emails.show');

    Route::post('/logout', [LoginController::class, 'destroy'])
        ->name('logout');
});

Route::post('/contact', [ContactController::class, 'send'])
    ->name('contact.send');

