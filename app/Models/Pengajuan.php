<?php

namespace App\Models;

use App\Enums\PengajuanStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pengajuan extends Model
{
    protected $fillable = [
        'user_id',
        'periode_bansos_id',
        'jenis_bantuan_id',
        'nomor_pengajuan',
        'status',
        'catatan',
        'submitted_at',
    ];

    protected function casts(): array
    {
        return [
            'status' => PengajuanStatus::class,
            'submitted_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function periodeBansos(): BelongsTo
    {
        return $this->belongsTo(PeriodeBansos::class);
    }

    public function jenisBantuan(): BelongsTo
    {
        return $this->belongsTo(JenisBantuan::class);
    }

    public function timelines(): HasMany
    {
        return $this->hasMany(PengajuanTimeline::class)->orderBy('occurred_at');
    }

    public function isDraft(): bool
    {
        return $this->status === PengajuanStatus::Draft;
    }
}
