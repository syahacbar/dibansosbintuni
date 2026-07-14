<?php

namespace App\Services\MasterData;

use App\Models\Fakultas;

class FakultasService extends MasterDataService
{
    protected function modelClass(): string
    {
        return Fakultas::class;
    }

    protected function searchableColumns(): array
    {
        return ['kode', 'nama', 'perguruanTinggi.nama'];
    }

    protected function relations(): array
    {
        return ['perguruanTinggi'];
    }
}
