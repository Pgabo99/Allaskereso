<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class JobOfferCreateRequest extends FormRequest
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
            'company_id'  => 'required|string|exists:company,id',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'salary_min'  => 'required|integer|min:0',
            'salary_max'  => 'required|integer|min:0|gte:salary_min',
            'location'    => 'required|string|max:255',
            'work_mode'   => 'required|in:ON_SITE,REMOTE,HYBRID',
            'job_id'      => 'required|string|exists:job,id',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'      => 'A pozíció neve kötelező.',
            'salary_min.required' => 'A minimális fizetés kötelező.',
            'salary_max.required' => 'A maximális fizetés kötelező.',
            'salary_max.gte'      => 'A maximális fizetés nem lehet kisebb a minimálisnál.',
            'location.required'   => 'A helyszín kötelező.',
            'work_mode.required'  => 'A munkavégzés módja kötelező.',
            'job_id.required'     => 'A munkakör kiválasztása kötelező.',
            'job_id.exists'       => 'A kiválasztott munkakör nem létezik.',
        ];
    }
}
