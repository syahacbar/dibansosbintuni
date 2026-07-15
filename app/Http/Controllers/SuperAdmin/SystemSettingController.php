<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SuperAdmin\SystemSettingRequest;
use App\Services\SuperAdmin\SystemSettingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SystemSettingController extends Controller
{
    public function __construct(private readonly SystemSettingService $settingService) {}

    public function edit(): View
    {
        return view('super-admin.settings.edit', [
            'settings' => $this->settingService->all(),
        ]);
    }

    public function update(SystemSettingRequest $request): RedirectResponse
    {
        $this->settingService->update($request->validated(), $request->file('logo'));

        return redirect()->route('super-admin.settings.edit')->with('success', 'Pengaturan sistem berhasil diperbarui.');
    }
}
