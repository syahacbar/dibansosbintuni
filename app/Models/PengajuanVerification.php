<?php

namespace App\Models;

use App\Enums\VerificationDecision;
use App\Enums\VerificationLayer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PengajuanVerification extends Model
{
    protected $fillable = [
        'pengajuan_id',
        'operator_id',
        'layer',
        'decision',
        'score',
        'metadata',
        'notes',
        'verified_at',
    ];

    protected function casts(): array
    {
        return [
            'layer' => VerificationLayer::class,
            'decision' => VerificationDecision::class,
            'score' => 'integer',
            'metadata' => 'array',
            'verified_at' => 'datetime',
        ];
    }

    public function pengajuan(): BelongsTo
    {
        return $this->belongsTo(Pengajuan::class);
    }

    public function operator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'operator_id');
    }
}
