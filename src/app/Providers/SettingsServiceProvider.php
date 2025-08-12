<?php

namespace App\Providers;

use App\Helpers\SettingsHelper;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;

class SettingsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('settings', function () {
            return new SettingsHelper();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Share settings with all views
        View::composer('*', function ($view) {
            $view->with([
                'siteSettings' => SettingsHelper::siteInfo(),
                'contactInfo' => SettingsHelper::contactInfo(),
                'socialLinks' => SettingsHelper::socialLinks(),
                'coursesInfo' => SettingsHelper::coursesInfo(),
            ]);
        });

        // Register Blade directives for easy access
        Blade::directive('setting', function ($expression) {
            return "<?php echo \App\Models\Setting::get($expression); ?>";
        });

        Blade::directive('phone', function () {
            return "<?php echo \App\Helpers\SettingsHelper::phone(); ?>";
        });

        Blade::directive('email', function () {
            return "<?php echo \App\Helpers\SettingsHelper::email(); ?>";
        });

        Blade::directive('facebook', function () {
            return "<?php echo \App\Helpers\SettingsHelper::facebookUrl(); ?>";
        });

        Blade::directive('youtube', function () {
            return "<?php echo \App\Helpers\SettingsHelper::youtubeUrl(); ?>";
        });

        Blade::directive('instagram', function () {
            return "<?php echo \App\Helpers\SettingsHelper::instagramUrl(); ?>";
        });

        Blade::directive('spotify', function () {
            return "<?php echo \App\Helpers\SettingsHelper::spotifyUrl(); ?>";
        });

        Blade::directive('whatsapp', function () {
            return "<?php echo \App\Helpers\SettingsHelper::whatsapp(); ?>";
        });

        Blade::directive('address', function () {
            return "<?php echo \App\Helpers\SettingsHelper::address(); ?>";
        });

        Blade::directive('siteTitle', function () {
            return "<?php echo \App\Helpers\SettingsHelper::siteTitle(); ?>";
        });

        Blade::directive('siteTagline', function () {
            return "<?php echo \App\Helpers\SettingsHelper::siteTagline(); ?>";
        });
    }
}
