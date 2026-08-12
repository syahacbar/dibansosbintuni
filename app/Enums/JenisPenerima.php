<?php

namespace App\Enums;

enum JenisPenerima: string
{
    case Oap = 'OAP';
    case Nusantara = 'Nusantara';

    public function label(): string
    {
        return match ($this) {
            self::Oap => 'OAP (Orang Asli Papua)',
            self::Nusantara => 'Nusantara (Non-OAP)',
        };
    }
}
