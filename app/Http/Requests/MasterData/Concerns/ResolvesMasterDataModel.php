<?php

namespace App\Http\Requests\MasterData\Concerns;

use Illuminate\Database\Eloquent\Model;

trait ResolvesMasterDataModel
{
    protected function currentModelId(): ?int
    {
        foreach ($this->route()?->parameters() ?? [] as $parameter) {
            if ($parameter instanceof Model) {
                return $parameter->getKey();
            }
        }

        return null;
    }
}
