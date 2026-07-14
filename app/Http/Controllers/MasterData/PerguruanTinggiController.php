<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Requests\MasterData\PerguruanTinggiRequest;
use App\Models\PerguruanTinggi;
use App\Services\MasterData\PerguruanTinggiService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PerguruanTinggiController extends MasterDataController
{
    public function __construct(PerguruanTinggiService $service)
    {
        parent::__construct($service);
    }

    protected function title(): string
    {
        return 'Perguruan Tinggi';
    }

    protected function routeName(): string
    {
        return 'master-data.perguruan-tinggi';
    }

    protected function fields(): array
    {
        return [
            ['name' => 'kode', 'label' => 'Kode', 'type' => 'text'],
            ['name' => 'nama', 'label' => 'Nama', 'type' => 'text'],
            ['name' => 'alamat', 'label' => 'Alamat', 'type' => 'textarea'],
            ['name' => 'aktif', 'label' => 'Aktif', 'type' => 'checkbox'],
        ];
    }

    protected function columns(): array
    {
        return [
            ['key' => 'kode', 'label' => 'Kode'],
            ['key' => 'nama', 'label' => 'Nama'],
            ['key' => 'alamat', 'label' => 'Alamat'],
            ['key' => 'aktif', 'label' => 'Status'],
        ];
    }

    public function store(PerguruanTinggiRequest $request): RedirectResponse
    {
        return $this->storeFromRequest($request);
    }

    public function show(PerguruanTinggi $perguruanTinggi): View
    {
        return $this->renderShow($perguruanTinggi);
    }

    public function edit(PerguruanTinggi $perguruanTinggi): View
    {
        return $this->renderEdit($perguruanTinggi);
    }

    public function update(PerguruanTinggiRequest $request, PerguruanTinggi $perguruanTinggi): RedirectResponse
    {
        return $this->updateFromRequest($request, $perguruanTinggi);
    }

    public function destroy(PerguruanTinggi $perguruanTinggi): RedirectResponse
    {
        return $this->destroyModel($perguruanTinggi);
    }
}
