<?php

namespace App\Services\MasterData;

use App\Models\Distrik;

class DistrikService extends MasterDataService
{
    protected function modelClass(): string
    {
        return Distrik::class;
    }
}
