<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RepertoireController;
use Illuminate\Support\Facades\Storage;

Route::permanentRedirect('/portale', '/')->name('legacy.portale');

Route::get('storage/{path}', function (string $path) {
    abort_if(
        str_contains($path, '..')
        || str_contains($path, '\\')
        || str_starts_with($path, '/'),
        404
    );

    $publicDisk = Storage::disk('public');

    if ($publicDisk->exists($path)) {
        return response()->file($publicDisk->path($path), [
            'Cache-Control' => 'public, max-age=31536000',
        ]);
    }

    $publicStorageRoot = public_path('storage');
    $publicStoragePath = $publicStorageRoot.'/'.$path;
    $realPublicStorageRoot = realpath($publicStorageRoot);
    $realPublicStoragePath = realpath($publicStoragePath);

    abort_unless(
        $realPublicStorageRoot
        && $realPublicStoragePath
        && str_starts_with($realPublicStoragePath, $realPublicStorageRoot.DIRECTORY_SEPARATOR)
        && is_file($realPublicStoragePath),
        404
    );

    return response()->file($realPublicStoragePath, [
        'Cache-Control' => 'public, max-age=31536000',
    ]);
})->where('path', '.*')->name('storage.public');

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => [ 'localize', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ],
], function() {

    // Home page
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Static pages
    Route::get(LaravelLocalization::transRoute('routes.chi-siamo'), [PageController::class, 'chiSiamo'])->name('chi-siamo');
    Route::get(LaravelLocalization::transRoute('routes.storia'), [PageController::class, 'storia'])->name('storia');
    Route::get(LaravelLocalization::transRoute('routes.organico'), [PageController::class, 'organico'])->name('organico');
    Route::get(LaravelLocalization::transRoute('routes.maestro'), [PageController::class, 'maestro'])->name('maestro');
    Route::get(LaravelLocalization::transRoute('routes.repertorio'), [RepertoireController::class, 'index'])->name('repertorio');
    Route::get(LaravelLocalization::transRoute('routes.abito-tradizionale'), [PageController::class, 'abitoTradizionale'])->name('abito-tradizionale');
    Route::get(LaravelLocalization::transRoute('routes.italia-gira-banda'), [PageController::class, 'italiaGiraBanda'])->name('italia-gira-banda');
    Route::get(LaravelLocalization::transRoute('routes.corsi-di-musica'), [PageController::class, 'corsiDiMusica'])
        ->name('corsi-di-musica');
    Route::get(LaravelLocalization::transRoute('routes.privacy-policy'), [PageController::class, 'privacyPolicy'])->name('privacy-policy');

    // Events
    Route::get(LaravelLocalization::transRoute('routes.eventi'), [EventController::class, 'index'])->name('eventi');
    Route::get(LaravelLocalization::transRoute('routes.eventi/{slug}'), [EventController::class, 'show'])->name('eventi.show');

    // Gallery
    Route::get(LaravelLocalization::transRoute('routes.galleria'), [GalleryController::class, 'index'])->name('galleria');
    Route::get(LaravelLocalization::transRoute('routes.galleria/{slug}'), [GalleryController::class, 'show'])->name('galleria.album');

    // Contact
    Route::get(LaravelLocalization::transRoute('routes.contatti'), [ContactController::class, 'index'])->name('contatti');
    Route::post(LaravelLocalization::transRoute('routes.contatti'), [ContactController::class, 'store'])->name('contatti.store');

});

// Sitemap (not localized, but contains localized URLs)
Route::get('sitemap.xml', function () {
    return response()->view('sitemap')
        ->header('Content-Type', 'application/xml');
})->name('sitemap');
