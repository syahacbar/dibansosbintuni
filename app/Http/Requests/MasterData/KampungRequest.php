<?php

namespace App\Http\Requests\MasterData;

use App\Http\Requests\MasterData\Concerns\ResolvesMasterDataModel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class KampungRequest extends FormRequest
{
    use ResolvesMasterDataModel;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'distrik_id' => ['required', 'integer', 'exists:distriks,id'],
            'kode' => ['required', 'string', 'max:50', Rule::unique('kampungs', 'kode')->ignore($this->currentModelId())],
            'nama' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'aktif' => ['nullable', 'boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['aktif' => $this->boolean('aktif')]);
    }
}
