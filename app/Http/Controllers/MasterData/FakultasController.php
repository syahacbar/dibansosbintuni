<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Requests\MasterData\FakultasRequest;
use App\Models\Fakultas;
use App\Models\PerguruanTinggi;
use App\Services\MasterData\FakultasService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FakultasController extends MasterDataController
{
    public function __construct(FakultasService $service)
    {
        parent::__construct($service);
    }

    protected function title(): string
    {
        return 'Fakultas';
    }

    protected function routeName(): string
    {
        return 'master-data.fakultas';
    }

    protected function fields(): array
    {
        return [
            ['name' => 'perguruan_tinggi_id', 'label' => 'Perguruan Tinggi', 'type' => 'select', 'options' => PerguruanTinggi::orderBy('nama')->pluck('nama', 'id')->all()],
            ['name' => 'kode', 'label' => 'Kode', 'type' => 'text'],
            ['name' => 'nama', 'label' => 'Nama', 'type' => 'text'],
            ['name' => 'deskripsi', 'label' => 'Deskripsi', 'type' => 'textarea'],
            ['name' => 'aktif', 'label' => 'Aktif', 'type' => 'checkbox'],
        ];
    }

    protected function columns(): array
    {
        return [
            ['key' => 'kode', 'label' => 'Kode'],
            ['key' => 'nama', 'label' => 'Nama'],
            ['key' => 'perguruanTinggi.nama', 'label' => 'Perguruan Tinggi'],
            ['key' => 'aktif', 'label' => 'Status'],
        ];
    }

    public function store(FakultasRequest $request): RedirectResponse
    {
        return $this->storeFromRequest($request);
    }

    public function show(Fakultas $fakultas): View
    {
        return $this->renderShow($fakultas);
    }

    public function edit(Fakultas $fakultas): View
    {
        return $this->renderEdit($fakultas);
    }

    public function update(FakultasRequest $request, Fakultas $fakultas): RedirectResponse
    {
        return $this->updateFromRequest($request, $fakultas);
    }

    public function destroy(Fakultas $fakultas): RedirectResponse
    {
        return $this->destroyModel($fakultas);
    }
}
