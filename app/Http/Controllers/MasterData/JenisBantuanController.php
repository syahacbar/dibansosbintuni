<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Requests\MasterData\JenisBantuanRequest;
use App\Models\JenisBantuan;
use App\Services\MasterData\JenisBantuanService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class JenisBantuanController extends MasterDataController
{
    public function __construct(JenisBantuanService $service)
    {
        parent::__construct($service);
    }

    protected function title(): string
    {
        return 'Jenis Bantuan';
    }

    protected function routeName(): string
    {
        return 'master-data.jenis-bantuan';
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

    public function store(JenisBantuanRequest $request): RedirectResponse
    {
        return $this->storeFromRequest($request);
    }

    public function show(JenisBantuan $jenisBantuan): View
    {
        return $this->renderShow($jenisBantuan);
    }

    public function edit(JenisBantuan $jenisBantuan): View
    {
        return $this->renderEdit($jenisBantuan);
    }

    public function update(JenisBantuanRequest $request, JenisBantuan $jenisBantuan): RedirectResponse
    {
        return $this->updateFromRequest($request, $jenisBantuan);
    }

    public function destroy(JenisBantuan $jenisBantuan): RedirectResponse
    {
        return $this->destroyModel($jenisBantuan);
    }
}
