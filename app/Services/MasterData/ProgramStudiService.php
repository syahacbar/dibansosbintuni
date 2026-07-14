<?php

namespace App\Services\MasterData;

use App\Models\ProgramStudi;

class ProgramStudiService extends MasterDataService
{
    protected function modelClass(): string
    {
        return ProgramStudi::class;
    }

    protected function searchableColumns(): array
    {
        return ['kode', 'nama', 'jenjang', 'fakultas.nama'];
    }

    protected function relations(): array
    {
        return ['fakultas.perguruanTinggi'];
    }
}
