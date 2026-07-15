<?php

namespace App\Enums;

enum PengajuanStatus: string
{
    case Draft = 'draft';
    case Diajukan = 'diajukan';

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Draft',
            self::Diajukan => 'Diajukan',
        };
    }
}
