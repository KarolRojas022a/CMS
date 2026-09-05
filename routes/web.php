<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Rutas Públicas (Páginas Estáticas)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])
->name('pages.home');

Route::get('/about', [HomeController::class, 'about'])
->name('pages.about');

Route::get('/contact', [HomeController::class, 'contact'])
->name('pages.contact');

Route::post('/contacto', [HomeController::class, 'sendContact'])
    ->middleware('throttle:10,1')
    ->name('contact.send');

/*
|--------------------------------------------------------------------------
| Rutas para Invitados (Usuarios NO Autenticados)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/registro', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/registro', [AuthController::class, 'register'])->name('register.store');

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:5,1')
        ->name('login.store');
});

/*
|--------------------------------------------------------------------------
| Rutas Privadas (Usuarios Autenticados)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Rutas CRUD completas para publicaciones
    Route::resource('posts', PostController::class);
     
});
