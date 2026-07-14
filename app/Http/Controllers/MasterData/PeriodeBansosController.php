<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Requests\MasterData\PeriodeBansosRequest;
use App\Models\PeriodeBansos;
use App\Services\MasterData\PeriodeBansosService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PeriodeBansosController extends MasterDataController
{
    public function __construct(PeriodeBansosService $service)
    {
        parent::__construct($service);
    }

    protected function title(): string
    {
        return 'Periode Bansos';
    }

    protected function routeName(): string
    {
        return 'master-data.periode-bansos';
    }

    protected function fields(): array
    {
        return [
            ['name' => 'kode', 'label' => 'Kode', 'type' => 'text'],
            ['name' => 'nama', 'label' => 'Nama', 'type' => 'text'],
            ['name' => 'tanggal_mulai', 'label' => 'Tanggal Mulai', 'type' => 'date'],
            ['name' => 'tanggal_selesai', 'label' => 'Tanggal Selesai', 'type' => 'date'],
            ['name' => 'deskripsi', 'label' => 'Deskripsi', 'type' => 'textarea'],
            ['name' => 'aktif', 'label' => 'Aktif', 'type' => 'checkbox'],
        ];
    }

    protected function columns(): array
    {
        return [
            ['key' => 'kode', 'label' => 'Kode'],
            ['key' => 'nama', 'label' => 'Nama'],
            ['key' => 'tanggal_mulai', 'label' => 'Mulai'],
            ['key' => 'tanggal_selesai', 'label' => 'Selesai'],
            ['key' => 'aktif', 'label' => 'Status'],
        ];
    }

    public function store(PeriodeBansosRequest $request): RedirectResponse
    {
        return $this->storeFromRequest($request);
    }

    public function show(PeriodeBansos $periodeBansos): View
    {
        return $this->renderShow($periodeBansos);
    }

    public function edit(PeriodeBansos $periodeBansos): View
    {
        return $this->renderEdit($periodeBansos);
    }

    public function update(PeriodeBansosRequest $request, PeriodeBansos $periodeBansos): RedirectResponse
    {
        return $this->updateFromRequest($request, $periodeBansos);
    }

    public function destroy(PeriodeBansos $periodeBansos): RedirectResponse
    {
        return $this->destroyModel($periodeBansos);
    }
}
