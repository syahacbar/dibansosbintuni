<?php

namespace App\Services\MasterData;

use App\Models\PerguruanTinggi;

class PerguruanTinggiService extends MasterDataService
{
    protected function modelClass(): string
    {
        return PerguruanTinggi::class;
    }
}
