<?php

namespace App\Http\Requests\Mahasiswa;

use App\Enums\StudentDocumentType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DocumentUploadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'document_type' => ['required', Rule::in(StudentDocumentType::values())],
            'document_file' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:4096'],
        ];
    }
}
