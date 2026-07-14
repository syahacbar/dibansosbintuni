<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Requests\MasterData\KampungRequest;
use App\Models\Distrik;
use App\Models\Kampung;
use App\Services\MasterData\KampungService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class KampungController extends MasterDataController
{
    public function __construct(KampungService $service)
    {
        parent::__construct($service);
    }

    protected function title(): string
    {
        return 'Kampung';
    }

    protected function routeName(): string
    {
        return 'master-data.kampung';
    }

    protected function fields(): array
    {
        return [
            ['name' => 'distrik_id', 'label' => 'Distrik', 'type' => 'select', 'options' => Distrik::orderBy('nama')->pluck('nama', 'id')->all()],
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
            ['key' => 'distrik.nama', 'label' => 'Distrik'],
            ['key' => 'aktif', 'label' => 'Status'],
        ];
    }

    public function store(KampungRequest $request): RedirectResponse
    {
        return $this->storeFromRequest($request);
    }

    public function show(Kampung $kampung): View
    {
        return $this->renderShow($kampung);
    }

    public function edit(Kampung $kampung): View
    {
        return $this->renderEdit($kampung);
    }

    public function update(KampungRequest $request, Kampung $kampung): RedirectResponse
    {
        return $this->updateFromRequest($request, $kampung);
    }

    public function destroy(Kampung $kampung): RedirectResponse
    {
        return $this->destroyModel($kampung);
    }
}
