<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Services\MasterData\MasterDataService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

abstract class MasterDataController extends Controller
{
    public function __construct(protected MasterDataService $service) {}

    abstract protected function title(): string;

    abstract protected function routeName(): string;

    /**
     * @return list<array<string, mixed>>
     */
    abstract protected function fields(): array;

    /**
     * @return list<array<string, string>>
     */
    protected function columns(): array
    {
        return [
            ['key' => 'kode', 'label' => 'Kode'],
            ['key' => 'nama', 'label' => 'Nama'],
            ['key' => 'aktif', 'label' => 'Status'],
        ];
    }

    public function index(Request $request): View
    {
        return view('master-data.index', [
            'title' => $this->title(),
            'routeName' => $this->routeName(),
            'columns' => $this->columns(),
            'items' => $this->service->paginate($request->string('search')->toString()),
            'search' => $request->string('search')->toString(),
        ]);
    }

    public function create(): View
    {
        return view('master-data.form', [
            'title' => $this->title(),
            'routeName' => $this->routeName(),
            'fields' => $this->fields(),
            'item' => null,
            'method' => 'POST',
            'action' => route($this->routeName().'.store'),
        ]);
    }

    protected function renderShow(Model $model): View
    {
        return view('master-data.show', [
            'title' => $this->title(),
            'routeName' => $this->routeName(),
            'columns' => $this->columns(),
            'fields' => $this->fields(),
            'item' => $model,
        ]);
    }

    protected function renderEdit(Model $model): View
    {
        return view('master-data.form', [
            'title' => $this->title(),
            'routeName' => $this->routeName(),
            'fields' => $this->fields(),
            'item' => $model,
            'method' => 'PUT',
            'action' => route($this->routeName().'.update', $model),
        ]);
    }

    protected function storeFromRequest(FormRequest $request): RedirectResponse
    {
        $this->service->create($request->validated());

        return redirect()
            ->route($this->routeName().'.index')
            ->with('success', $this->title().' berhasil ditambahkan.');
    }

    protected function updateFromRequest(FormRequest $request, Model $model): RedirectResponse
    {
        $this->service->update($model, $request->validated());

        return redirect()
            ->route($this->routeName().'.index')
            ->with('success', $this->title().' berhasil diperbarui.');
    }

    protected function destroyModel(Model $model): RedirectResponse
    {
        $this->service->delete($model);

        return redirect()
            ->route($this->routeName().'.index')
            ->with('success', $this->title().' berhasil dihapus.');
    }
}
