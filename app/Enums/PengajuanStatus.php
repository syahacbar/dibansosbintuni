<?php

namespace App\Enums;

enum PengajuanStatus: string
{
    case Draft = 'draft';
    case Diajukan = 'diajukan';
    case Disetujui = 'disetujui';
    case Disalurkan = 'disalurkan';
    case Revisi = 'revisi';
    case Ditolak = 'ditolak';

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Draft',
            self::Diajukan => 'Diajukan',
            self::Disetujui => 'Disetujui',
            self::Disalurkan => 'Disalurkan',
            self::Revisi => 'Revisi',
            self::Ditolak => 'Ditolak',
        };
    }
}
