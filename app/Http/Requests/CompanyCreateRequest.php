<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CompanyCreateRequest extends FormRequest
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
            'name'                => 'required|string|max:255',
            'contact_email'       => 'required|email|max:255',
            'location'            => 'required|string|max:255',
            'tax_id'              => 'required|string|max:20',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'                => 'A cég neve kötelező.',
            'contact_email.required'       => 'A kapcsolattartó email kötelező.',
            'contact_email.email'          => 'Érvényes email címet adj meg.',
            'location.required'            => 'A székhely kötelező.',
            'tax_id.required'              => 'Az adószám kötelező.',
        ];
    }
}
