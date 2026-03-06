<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\{View, Cache, Schema};
use App\Models\AdminPanelSetting;
class AppServiceProvider extends ServiceProvider {
    public function register(): void {
        //
    }

    /*public function boot(): void {
        if (Schema::hasTable('admin_panel_settings')) {
            $settings = Cache::remember('app_settings', 60 * 60, function () {
                $company_code = get_user_data()?->company_id;
                return AdminPanelSetting::with(['media'])->where('company_id', $company_code)->orderBy('created_at', 'DESC')->first();
            });
            View::share('settings', $settings);
            $logo = null;
            $favicon = null;
            if ($settings) {
                if ($settings->media->isNotEmpty()) {
                    $logo = $settings->getMediaUrl('setting', $settings, null, 'media', 'logo');
                    $favicon = $settings->getMediaUrl('setting', $settings, null, 'media', 'favicon');
                }
            }
            $logo = $logo ?? asset('dashboard/assets/images/default/default.png');
            $favicon = $favicon ?? asset('dashboard/assets/images/default/default.png');
            View::share(compact('logo', 'favicon'));
        }
    }*/
    public function boot(): void {
        if (Schema::hasTable('admin_panel_settings')) {
            $company_code = get_user_data()?->company_id;

            $settings = Cache::remember('app_settings_' . ($company_code ?? 'default'), 3600, function () use ($company_code) {
                $query = AdminPanelSetting::with('media')->orderBy('created_at', 'DESC');
                if ($company_code) {
                    $query->where('company_id', $company_code);
                }
                return $query->first();
            });

            $logo = $settings?->getMediaUrl('setting', $settings, null, 'media', 'logo')
                ?? asset('dashboard/assets/images/default/default.png');

            $favicon = $settings?->getMediaUrl('setting', $settings, null, 'media', 'favicon')
                ?? asset('dashboard/assets/images/default/default.png');

            View::share(compact('settings', 'logo', 'favicon'));
        }
    }
}
