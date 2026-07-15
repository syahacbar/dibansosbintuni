<?php

namespace App\Enums;

enum StudentDocumentType: string
{
    case Ktp = 'ktp';
    case Kk = 'kk';
    case Ktm = 'ktm';
    case SuratAktif = 'surat_aktif';
    case Khs = 'khs';
    case BukuRekening = 'buku_rekening';

    public function label(): string
    {
        return match ($this) {
            self::Ktp => 'KTP',
            self::Kk => 'KK',
            self::Ktm => 'KTM',
            self::SuratAktif => 'Surat Aktif',
            self::Khs => 'KHS',
            self::BukuRekening => 'Buku Rekening',
        };
    }

    /**
     * @return array<string, string>
     */
    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $type): array => [$type->value => $type->label()])
            ->all();
    }

    /**
     * @return list<string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
