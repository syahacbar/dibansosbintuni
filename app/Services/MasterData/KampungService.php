<?php

namespace App\Services\MasterData;

use App\Models\Kampung;

class KampungService extends MasterDataService
{
    protected function modelClass(): string
    {
        return Kampung::class;
    }

    protected function searchableColumns(): array
    {
        return ['kode', 'nama', 'distrik.nama'];
    }

    protected function relations(): array
    {
        return ['distrik'];
    }
}
