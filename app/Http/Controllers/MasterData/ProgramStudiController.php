<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Requests\MasterData\ProgramStudiRequest;
use App\Models\Fakultas;
use App\Models\ProgramStudi;
use App\Services\MasterData\ProgramStudiService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProgramStudiController extends MasterDataController
{
    public function __construct(ProgramStudiService $service)
    {
        parent::__construct($service);
    }

    protected function title(): string
    {
        return 'Program Studi';
    }

    protected function routeName(): string
    {
        return 'master-data.program-studi';
    }

    protected function fields(): array
    {
        return [
            ['name' => 'fakultas_id', 'label' => 'Fakultas', 'type' => 'select', 'options' => Fakultas::with('perguruanTinggi')->orderBy('nama')->get()->mapWithKeys(fn (Fakultas $fakultas) => [$fakultas->id => $fakultas->nama.' - '.$fakultas->perguruanTinggi?->nama])->all()],
            ['name' => 'kode', 'label' => 'Kode', 'type' => 'text'],
            ['name' => 'nama', 'label' => 'Nama', 'type' => 'text'],
            ['name' => 'jenjang', 'label' => 'Jenjang', 'type' => 'select', 'options' => ['D3' => 'D3', 'D4' => 'D4', 'S1' => 'S1', 'S2' => 'S2', 'S3' => 'S3']],
            ['name' => 'deskripsi', 'label' => 'Deskripsi', 'type' => 'textarea'],
            ['name' => 'aktif', 'label' => 'Aktif', 'type' => 'checkbox'],
        ];
    }

    protected function columns(): array
    {
        return [
            ['key' => 'kode', 'label' => 'Kode'],
            ['key' => 'nama', 'label' => 'Nama'],
            ['key' => 'jenjang', 'label' => 'Jenjang'],
            ['key' => 'fakultas.nama', 'label' => 'Fakultas'],
            ['key' => 'aktif', 'label' => 'Status'],
        ];
    }

    public function store(ProgramStudiRequest $request): RedirectResponse
    {
        return $this->storeFromRequest($request);
    }

    public function show(ProgramStudi $programStudi): View
    {
        return $this->renderShow($programStudi);
    }

    public function edit(ProgramStudi $programStudi): View
    {
        return $this->renderEdit($programStudi);
    }

    public function update(ProgramStudiRequest $request, ProgramStudi $programStudi): RedirectResponse
    {
        return $this->updateFromRequest($request, $programStudi);
    }

    public function destroy(ProgramStudi $programStudi): RedirectResponse
    {
        return $this->destroyModel($programStudi);
    }
}
