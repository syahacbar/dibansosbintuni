<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Requests\MasterData\DistrikRequest;
use App\Models\Distrik;
use App\Services\MasterData\DistrikService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DistrikController extends MasterDataController
{
    public function __construct(DistrikService $service)
    {
        parent::__construct($service);
    }

    protected function title(): string
    {
        return 'Distrik';
    }

    protected function routeName(): string
    {
        return 'master-data.distrik';
    }

    protected function fields(): array
    {
        return [
            ['name' => 'kode', 'label' => 'Kode', 'type' => 'text'],
            ['name' => 'nama', 'label' => 'Nama', 'type' => 'text'],
            ['name' => 'deskripsi', 'label' => 'Deskripsi', 'type' => 'textarea'],
            ['name' => 'aktif', 'label' => 'Aktif', 'type' => 'checkbox'],
        ];
    }

    public function store(DistrikRequest $request): RedirectResponse
    {
        return $this->storeFromRequest($request);
    }

    public function show(Distrik $distrik): View
    {
        return $this->renderShow($distrik);
    }

    public function edit(Distrik $distrik): View
    {
        return $this->renderEdit($distrik);
    }

    public function update(DistrikRequest $request, Distrik $distrik): RedirectResponse
    {
        return $this->updateFromRequest($request, $distrik);
    }

    public function destroy(Distrik $distrik): RedirectResponse
    {
        return $this->destroyModel($distrik);
    }
}
