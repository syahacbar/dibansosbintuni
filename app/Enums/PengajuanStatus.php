<?php

namespace App\Enums;

enum PengajuanStatus: string
{
    case Draft = 'draft';
    case Diajukan = 'diajukan';
    case Disetujui = 'disetujui';
    case Revisi = 'revisi';
    case Ditolak = 'ditolak';

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Draft',
            self::Diajukan => 'Diajukan',
            self::Disetujui => 'Disetujui',
            self::Revisi => 'Revisi',
            self::Ditolak => 'Ditolak',
        };
    }
}
