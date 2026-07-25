<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Filament\SpatieLaravelTranslatablePlugin;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentView;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Livewire\Livewire;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
                \App\Filament\Pages\ArtisanCommands::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->navigationGroups([
                __('filament.navigation_groups.system'),
                __('filament.navigation_groups.content_management'),
            ])
            ->plugin(
                SpatieLaravelTranslatablePlugin::make()
                    ->defaultLocales(array_keys(config('laravellocalization.supportedLocales', [])))
            )

            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }

    public function boot(): void
    {
        $appPath = trim((string) parse_url((string) config('app.url'), PHP_URL_PATH), '/');

        if ($appPath !== '') {
            config(['livewire.asset_url' => "/{$appPath}/livewire/livewire.js"]);

            Livewire::setUpdateRoute(function ($handle) use ($appPath) {
                return Route::post("/{$appPath}/livewire/update", $handle)
                    ->middleware('web')
                    ->name('subfolder.livewire.update');
            });
        }

        FilamentAsset::register([
            Js::make('multi-image-uploader', __DIR__ . '/../../../resources/js/filament/components/multi-image-uploader.js'),
        ]);

        FilamentView::registerRenderHook(
            'panels::head.start',
            fn (): string => view('filament.partials.repair-persisted-state')->render() .
                '<link rel="stylesheet" href="' . asset('css/instrument-icons.css') . '">' .
                '<link rel="stylesheet" href="' . asset('css/filament-admin-responsive.css') . '">'
        );
    }
}
