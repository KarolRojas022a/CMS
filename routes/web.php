<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReceivedEmailController;
use App\Http\Controllers\UserManagementController;
use App\Http\Middleware\EnsureUserIsActive;
use App\Http\Middleware\EnsureUserIsAdmin;
use Illuminate\Support\Facades\Route;

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

Route::get('/publicaciones', [PostController::class, 'publicIndex'])
    ->name('pages.posts');

// ---------- Autenticación (solo invitados) ----------
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'store'])
        ->middleware('throttle:login')
        ->name('login.store');
});

// ---------- Zona protegida (solo autenticados) ----------
Route::middleware(['auth', EnsureUserIsActive::class])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::resource('dashboard/posts', PostController::class)
        ->except(['show'])
        ->names([
            'index' => 'posts.index',
            'create' => 'posts.create',
            'store' => 'posts.store',
            'edit' => 'posts.edit',
            'update' => 'posts.update',
            'destroy' => 'posts.destroy',
        ]);

    Route::get('/dashboard/received-emails', [ReceivedEmailController::class, 'index'])
        ->name('received-emails.index');

    Route::get('/dashboard/received-emails/{receivedEmail}', [ReceivedEmailController::class, 'show'])
        ->name('received-emails.show');

    Route::middleware(EnsureUserIsAdmin::class)
        ->prefix('/dashboard/users')
        ->name('users.')
        ->controller(UserManagementController::class)
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/{user}/edit', 'edit')->name('edit');
            Route::put('/{user}', 'update')->name('update');
            Route::put('/{user}/password', 'updatePassword')->name('password');
            Route::patch('/{user}/status', 'updateStatus')->name('status');
        });

    Route::post('/logout', [LoginController::class, 'destroy'])
        ->name('logout');
});

Route::post('/contact', [ContactController::class, 'send'])
    ->name('contact.send');
