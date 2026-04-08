<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ApplicationCreateRequest extends FormRequest
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
            'job_offer_id' => 'required|string|exists:job_offer,id',
            'cv' => 'required|file|mimes:pdf,doc,docx|max:5120',
        ];
    }

    public function messages(): array
    {
        return [
            'job_offer_id.required' => 'Az álláshirdetés azonosítója kötelező.',
            'job_offer_id.exists' => 'Az álláshirdetés nem létezik.',
            'cv.required' => 'Az önéletrajz feltöltése kötelező.',
            'cv.file' => 'Az önéletrajznak fájlnak kell lennie.',
            'cv.mimes' => 'Az önéletrajz csak PDF, DOC vagy DOCX formátumú lehet.',
            'cv.max' => 'Az önéletrajz mérete nem haladhatja meg az 5 MB-ot.',
        ];
    }
}
