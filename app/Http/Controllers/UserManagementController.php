<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class UserManagementController extends Controller
{
    public function index(Request $request): View
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
        ]);

        $search = $validated['search'] ?? '';

        return view('users.index', [
            'users' => User::query()
                ->when($search !== '', function ($query) use ($search) {
                    $query->where(function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
                })
                ->orderBy('name')
                ->paginate(15)
                ->withQueryString(),
            'search' => $search,
        ]);
    }

    public function create(): View
    {
        return view('users.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'role' => ['required', Rule::in(['admin', 'editor'])],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        User::query()->create([
            ...$validated,
            'is_active' => true,
        ]);

        return redirect()->route('users.index')->with('status', 'La cuenta se creó correctamente.');
    }

    public function edit(User $user): View
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'role' => ['required', Rule::in(['admin', 'editor'])],
        ]);

        if ($request->user()->is($user) && $validated['role'] !== 'admin') {
            return back()->withInput()->withErrors([
                'role' => 'No puedes quitarte el rol de administrador.',
            ]);
        }

        DB::transaction(function () use ($validated, $user): void {
            if ($user->is_active && $user->isAdmin() && $validated['role'] !== 'admin') {
                $this->ensureAnotherActiveAdminExists();
            }

            $user->update($validated);
        });

        return redirect()->route('users.index')->with('status', 'La cuenta se actualizó correctamente.');
    }

    public function updatePassword(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('users.edit', $user)->with('status', 'La contraseña se restableció correctamente.');
    }

    public function updateStatus(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'is_active' => ['required', 'boolean'],
        ]);

        if (! $validated['is_active'] && $request->user()->is($user)) {
            return back()->withErrors([
                'is_active' => 'No puedes desactivar tu propia cuenta.',
            ]);
        }

        DB::transaction(function () use ($validated, $user): void {
            if (! $validated['is_active'] && $user->is_active && $user->isAdmin()) {
                $this->ensureAnotherActiveAdminExists();
            }

            $user->update(['is_active' => $validated['is_active']]);
        });

        $message = $validated['is_active']
            ? 'La cuenta se activó correctamente.'
            : 'La cuenta se desactivó correctamente.';

        return redirect()->route('users.index')->with('status', $message);
    }

    private function ensureAnotherActiveAdminExists(): void
    {
        $activeAdminCount = User::query()
            ->where('role', 'admin')
            ->where('is_active', true)
            ->lockForUpdate()
            ->count();

        if ($activeAdminCount <= 1) {
            throw ValidationException::withMessages([
                'role' => 'No puedes quitar el acceso al último administrador activo.',
            ]);
        }
    }
}
