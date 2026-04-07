<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CompanyAddEmployeeRequest extends FormRequest
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
            'identifier' => 'required|string',
            'rights' => 'array',
            'rights.*' => 'string|in:CREATE_JOB_OFFER,HANDLE_APPLICATIONS,EDIT_COMPANY_DATA',
        ];
    }

    public function messages(): array
    {
        return [
            'identifier.required' => 'Az email cím vagy felhasználónév kötelező.',
            'rights.*.in' => 'Érvénytelen jogosultság.',
        ];
    }
}
