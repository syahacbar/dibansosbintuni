<?php

namespace App\Http\Requests\Mahasiswa;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $profileId = $this->user()?->mahasiswaProfile?->id;

        return [
            'nik' => ['nullable', 'string', 'max:20', Rule::unique('mahasiswa_profiles', 'nik')->ignore($profileId)],
            'nim' => ['nullable', 'string', 'max:50', Rule::unique('mahasiswa_profiles', 'nim')->ignore($profileId)],
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'tempat_lahir' => ['nullable', 'string', 'max:255'],
            'tanggal_lahir' => ['nullable', 'date', 'before:today'],
            'jenis_kelamin' => ['nullable', Rule::in(['L', 'P'])],
            'no_hp' => ['nullable', 'string', 'max:30'],
            'nama_ayah' => ['nullable', 'string', 'max:255'],
            'pekerjaan_ayah' => ['nullable', 'string', 'max:255'],
            'nama_ibu' => ['nullable', 'string', 'max:255'],
            'pekerjaan_ibu' => ['nullable', 'string', 'max:255'],
            'program_studi_id' => ['nullable', 'integer', 'exists:program_studis,id'],
            'perguruan_tinggi_nama' => ['nullable', 'string', 'max:255'],
            'fakultas_nama' => ['nullable', 'string', 'max:255'],
            'program_studi_nama' => ['nullable', 'string', 'max:255'],
            'semester' => ['nullable', 'integer', 'min:1', 'max:20'],
            'ipk' => ['nullable', 'numeric', 'min:0', 'max:4'],
            'nama_bank' => ['nullable', 'string', 'max:255'],
            'nomor_rekening' => ['nullable', 'string', 'max:50'],
            'nama_pemilik_rekening' => ['nullable', 'string', 'max:255'],
            'distrik_id' => ['nullable', 'integer', 'exists:distriks,id'],
            'kampung_id' => ['nullable', 'integer', 'exists:kampungs,id'],
            'alamat' => ['nullable', 'string'],
            'rt' => ['nullable', 'string', 'max:10'],
            'rw' => ['nullable', 'string', 'max:10'],
        ];
    }
}
