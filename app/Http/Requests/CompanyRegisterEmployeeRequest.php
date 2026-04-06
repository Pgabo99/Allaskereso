<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CompanyRegisterEmployeeRequest extends FormRequest
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
        return [
            'name'                  => 'required|string|max:255',
            'username'              => 'required|string|unique:users,username',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|min:8|confirmed',
            'birth_date'            => 'required|date',
            'rights'                => 'array',
            'rights.*'              => 'string|in:CREATE_JOB_OFFER,HANDLE_APPLICATIONS,EDIT_COMPANY_DATA',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'         => 'A név megadása kötelező.',
            'username.required'     => 'A felhasználónév megadása kötelező.',
            'username.unique'       => 'Ez a felhasználónév már foglalt.',
            'email.required'        => 'Az email megadása kötelező.',
            'email.email'           => 'Érvénytelen email formátum.',
            'email.unique'          => 'Ez az email már foglalt.',
            'password.required'     => 'A jelszó kötelező.',
            'password.min'          => 'A jelszónak legalább 8 karakter hosszúnak kell lennie.',
            'password.confirmed'    => 'A jelszavak nem egyeznek.',
            'birth_date.required'   => 'A születési dátum kötelező.',
            'birth_date.date'       => 'Érvénytelen dátum formátum.',
            'rights.*.in'           => 'Érvénytelen jogosultság.',
        ];
    }
}
