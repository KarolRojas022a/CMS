<?php
// filepath: C:\xampp\htdocs\cms\app\Http\Controllers\Auth\LoginController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt(
            $credentials,
            $request->boolean('remember')
        )) {
            return back()
                ->withErrors([
                    'email' => 'Las credenciales proporcionadas no son válidas.',
                ])
                ->onlyInput('email');
        }

        // Evita la fijación de sesión después de autenticarse.
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        // Invalida toda la sesión existente.
        $request->session()->invalidate();

        // Genera un nuevo token CSRF.
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
