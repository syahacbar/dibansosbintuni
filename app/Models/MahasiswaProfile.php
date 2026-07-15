<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MahasiswaProfile extends Model
{
    protected $fillable = [
        'user_id',
        'program_studi_id',
        'distrik_id',
        'kampung_id',
        'nik',
        'nim',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'no_hp',
        'nama_ayah',
        'pekerjaan_ayah',
        'nama_ibu',
        'pekerjaan_ibu',
        'perguruan_tinggi_nama',
        'fakultas_nama',
        'program_studi_nama',
        'semester',
        'ipk',
        'nama_bank',
        'nomor_rekening',
        'nama_pemilik_rekening',
        'alamat',
        'rt',
        'rw',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
            'ipk' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function programStudi(): BelongsTo
    {
        return $this->belongsTo(ProgramStudi::class);
    }

    public function distrik(): BelongsTo
    {
        return $this->belongsTo(Distrik::class);
    }

    public function kampung(): BelongsTo
    {
        return $this->belongsTo(Kampung::class);
    }
}
