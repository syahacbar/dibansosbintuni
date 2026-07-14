<?php

namespace App\Services\MasterData;

use App\Models\JenisBantuan;

class JenisBantuanService extends MasterDataService
{
    protected function modelClass(): string
    {
        return JenisBantuan::class;
    }
}
