<?php

namespace App\Http\Requests\Operator;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VerificationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'decision' => ['required', Rule::in(['approve', 'revision', 'reject'])],
            'notes' => ['nullable', 'string', 'max:2000', 'required_if:decision,revision,reject'],
        ];
    }
}
