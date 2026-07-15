<?php

namespace App\Services\SuperAdmin;

use App\Models\SystemSetting;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class SystemSettingService
{
    public function all(): array
    {
        return SystemSetting::pluck('value', 'key')->all();
    }

    public function update(array $data, ?UploadedFile $logo = null): void
    {
        $settings = [
            'active_year' => $data['active_year'],
        ];

        if ($logo) {
            $oldLogo = SystemSetting::where('key', 'logo_path')->value('value');
            if ($oldLogo) {
                Storage::disk('public')->delete($oldLogo);
            }

            $settings['logo_path'] = $logo->store('settings', 'public');
        }

        foreach ($settings as $key => $value) {
            SystemSetting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
