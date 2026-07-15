<?php

namespace App\Http\Requests\Mahasiswa;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PengajuanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $pengajuanId = $this->route('pengajuan')?->id;

        return [
            'periode_bansos_id' => ['required', 'integer', 'exists:periode_bansos,id'],
            'jenis_bantuan_id' => [
                'required',
                'integer',
                'exists:jenis_bantuans,id',
                Rule::unique('pengajuans', 'jenis_bantuan_id')
                    ->where('user_id', $this->user()->id)
                    ->where('periode_bansos_id', $this->input('periode_bansos_id'))
                    ->ignore($pengajuanId),
            ],
            'catatan' => ['nullable', 'string'],
        ];
    }
}
