<?php

namespace App\Providers;

use App\Models\FrontendSetting;
use App\Models\Post;
use App\Models\Setting;
use App\Observers\PostObserver;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Force HTTPS if the REDIRECT_HTTPS environment variable is set
        if (env('REDIRECT_HTTPS')) {
            URL::forceScheme('https');
        }

        // Observe the Post model
        Post::observe(PostObserver::class);

        // Share unread notifications count with all views for authenticated admin users
        View::composer('*', function ($view) {
            if (Auth::guard('admin')->check()) {
                $user = Auth::guard('admin')->user();
                $unreadNotificationsCount = $user->unreadNotifications->count();
                $view->with('unreadNotificationsCount', $unreadNotificationsCount);
            }
        });
             // Share the settings with all views
             $setting = Setting::first(); // Fetch the first setting
             View::share('setting', $setting); // Share it globally


             $frontendSettings = FrontendSetting::first();
             View::share('frontendSettings', $frontendSettings);

        // if (Schema::hasTable('settings')) {
        //     $settings = \App\Models\Setting::first();
        //     // Other logic that depends on `settings` data
        // }
    }
}
