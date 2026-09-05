<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    // 1. Cambia esto a true para permitir que el usuario pase la validación
    public function authorize(): bool
    {
        return true;
    }

    // 2. Define las reglas de validación
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:150'],
            'body'  => ['required', 'string', 'max:10000'],
        ];
    }
}
