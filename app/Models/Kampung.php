<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kampung extends Model
{
    protected $fillable = [
        'distrik_id',
        'kode',
        'nama',
        'deskripsi',
        'aktif',
    ];

    protected function casts(): array
    {
        return [
            'aktif' => 'boolean',
        ];
    }

    public function distrik(): BelongsTo
    {
        return $this->belongsTo(Distrik::class);
    }
}
