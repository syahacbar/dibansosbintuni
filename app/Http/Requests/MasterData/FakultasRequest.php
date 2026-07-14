<?php

namespace App\Http\Requests\MasterData;

use App\Http\Requests\MasterData\Concerns\ResolvesMasterDataModel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FakultasRequest extends FormRequest
{
    use ResolvesMasterDataModel;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'perguruan_tinggi_id' => ['required', 'integer', 'exists:perguruan_tinggis,id'],
            'kode' => ['required', 'string', 'max:50', Rule::unique('fakultas', 'kode')->ignore($this->currentModelId())],
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
