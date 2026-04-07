<?php

namespace App\Http\Requests;

use App\UserRoleEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->user()->id;

        return [
            'email'     => ['required', 'email', Rule::unique('user', 'email')->ignore($userId, '_id')],
            'username'  => ['required', 'string', Rule::unique('user', 'username')->ignore($userId, '_id')],
            'name'      => 'required|string',
            'birth_date' => 'required|date',
            'password'  => 'nullable|min:8|confirmed',
            'role'      => ['nullable', Rule::enum(UserRoleEnum::class)],
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'email.required'    => 'Az email megadása kötelező.',
            'email.email'       => 'Érvénytelen email formátum.',
            'email.unique'      => 'Ez az email már foglalt.',

            'username.required' => 'A felhasználónév megadása kötelező.',
            'username.unique'   => 'Ez a felhasználónév már foglalt.',

            'name.required'     => 'A név megadása kötelező.',

            'birth_date.required' => 'A születési dátum kötelező.',
            'birth_date.date'   => 'Érvénytelen dátum formátum.',

            'password.min'      => 'A jelszónak legalább 8 karakter hosszúnak kell lennie.',
            'password.confirmed' => 'A jelszavak nem egyeznek.',

            'role.enum'         => 'Érvénytelen jogosultság.',
        ];
    }
}