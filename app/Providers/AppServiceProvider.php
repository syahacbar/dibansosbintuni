<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        try {
            $sourceLogo = public_path('images/logo-official-dibansos.png');
            if (file_exists($sourceLogo)) {
                $targets = [
                    storage_path('app/public/settings/logo-official-dibansos.png'),
                    public_path('storage/settings/logo-official-dibansos.png'),
                ];

                foreach ($targets as $destPath) {
                    if (! file_exists(dirname($destPath))) {
                        @mkdir(dirname($destPath), 0755, true);
                    }
                    if (! file_exists($destPath)) {
                        @copy($sourceLogo, $destPath);
                    }
                }

                \App\Models\SystemSetting::firstOrCreate(
                    ['key' => 'logo_path'],
                    ['value' => 'settings/logo-official-dibansos.png']
                );
            }
        } catch (\Throwable $e) {
            // fallback gracefully
        }
    }
}
