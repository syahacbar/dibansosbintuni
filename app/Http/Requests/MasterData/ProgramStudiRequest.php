<?php

namespace App\Http\Requests\MasterData;

use App\Http\Requests\MasterData\Concerns\ResolvesMasterDataModel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProgramStudiRequest extends FormRequest
{
    use ResolvesMasterDataModel;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'fakultas_id' => ['required', 'integer', 'exists:fakultas,id'],
            'kode' => ['required', 'string', 'max:50', Rule::unique('program_studis', 'kode')->ignore($this->currentModelId())],
            'nama' => ['required', 'string', 'max:255'],
            'jenjang' => ['required', 'string', 'max:20'],
            'deskripsi' => ['nullable', 'string'],
            'aktif' => ['nullable', 'boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['aktif' => $this->boolean('aktif')]);
    }
}
