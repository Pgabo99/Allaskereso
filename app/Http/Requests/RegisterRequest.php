<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|unique:users,username',
            'password' => 'required|min:8|confirmed',
            'name' => 'required|string',
            'birth_date' => 'required|date',
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'email.required' => 'Az email megadása kötelező.',
            'email.email' => 'Érvénytelen email formátum.',
            'email.unique' => 'Ez az email már foglalt.',

            'username.required' => 'A felhasználónév megadása kötelező.',
            'username.unique' => 'Ez a felhasználónév már foglalt.',

            'password.required' => 'A jelszó kötelező.',
            'password.min' => 'A jelszónak legalább 8 karakter hosszúnak kell lennie.',
            'password.confirmed' => 'A jelszavak nem egyeznek.',

            'name.required' => 'A név megadása kötelező.',

            'birth_date.required' => 'A születési dátum kötelező.',
            'birth_date.date' => 'Érvénytelen dátum formátum.',
        ];
    }
}
