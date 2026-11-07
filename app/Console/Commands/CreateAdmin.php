<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateAdmin extends Command
{
    protected $signature = 'cms:create-admin';

    protected $description = 'Crea la cuenta inicial de administración del CMS';

    public function handle(): int
    {
        $name = $this->ask('Nombre');
        $email = $this->ask('Correo electrónico');
        $password = $this->secret('Contraseña (mínimo 8 caracteres)');
        $passwordConfirmation = $this->secret('Confirma la contraseña');

        $validator = Validator::make([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $passwordConfirmation,
        ], [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return self::FAILURE;
        }

        User::query()->create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'admin',
            'is_active' => true,
        ]);

        $this->info('La cuenta administradora se creó correctamente.');

        return self::SUCCESS;
    }
}
