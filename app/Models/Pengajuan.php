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
        'verification_score',
        'catatan',
        'verification_notes',
        'verified_by',
        'verified_at',
        'submitted_at',
    ];

    protected function casts(): array
    {
        return [
            'status' => PengajuanStatus::class,
            'verification_score' => 'integer',
            'submitted_at' => 'datetime',
            'verified_at' => 'datetime',
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

    public function verifications(): HasMany
    {
        return $this->hasMany(PengajuanVerification::class)->latest('verified_at');
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function isDraft(): bool
    {
        return $this->status === PengajuanStatus::Draft;
    }

    public function canBeVerified(): bool
    {
        return $this->status === PengajuanStatus::Diajukan;
    }
}
