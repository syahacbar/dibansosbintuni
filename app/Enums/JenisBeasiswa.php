<?php

namespace App\Enums;

enum JenisBeasiswa: string
{
    case Umum = 'umum';
    case Kedinasan = 'kedinasan';

    public function label(): string
    {
        return match ($this) {
            self::Umum => 'Umum',
            self::Kedinasan => 'Kedinasan',
        };
    }
}
