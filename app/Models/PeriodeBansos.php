<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeriodeBansos extends Model
{
    protected $fillable = [
        'kode',
        'nama',
        'tanggal_mulai',
        'tanggal_selesai',
        'deskripsi',
        'aktif',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_mulai' => 'date',
            'tanggal_selesai' => 'date',
            'aktif' => 'boolean',
        ];
    }
}
