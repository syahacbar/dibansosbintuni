<?php

namespace App\Services\MasterData;

use App\Models\PeriodeBansos;

class PeriodeBansosService extends MasterDataService
{
    protected function modelClass(): string
    {
        return PeriodeBansos::class;
    }
}
