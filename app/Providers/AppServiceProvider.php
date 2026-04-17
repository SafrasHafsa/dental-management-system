<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Share clinic settings with all views
        view()->composer('*', function ($view) {
            static $settings = null;
            if ($settings === null) {
                try {
                    $settings = \Illuminate\Support\Facades\DB::table('clinic_settings')
                        ->pluck('value', 'key');
                } catch (\Throwable) {
                    $settings = collect();
                }
            }
            $view->with('clinicSettings', $settings);
        });
    }
}
