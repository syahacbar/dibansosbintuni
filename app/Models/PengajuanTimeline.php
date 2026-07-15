<?php

namespace App\Models;

use App\Enums\PengajuanStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PengajuanTimeline extends Model
{
    protected $fillable = [
        'pengajuan_id',
        'status',
        'label',
        'description',
        'occurred_at',
    ];

    protected function casts(): array
    {
        return [
            'status' => PengajuanStatus::class,
            'occurred_at' => 'datetime',
        ];
    }

    public function pengajuan(): BelongsTo
    {
        return $this->belongsTo(Pengajuan::class);
    }
}
