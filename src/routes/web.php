<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\PageController;

// Home page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Static pages
Route::get('/chi-siamo', [PageController::class, 'chiSiamo'])->name('chi-siamo');
Route::get('/storia', [PageController::class, 'storia'])->name('storia');
Route::get('/organico', [PageController::class, 'organico'])->name('organico');
Route::get('/maestro', [PageController::class, 'maestro'])->name('maestro');
Route::get('/repertorio', [PageController::class, 'repertorio'])->name('repertorio');
Route::get('/abito-tradizionale', [PageController::class, 'abitoTradizionale'])->name('abito-tradizionale');
Route::get('/italia-gira-banda', [PageController::class, 'italiaGiraBanda'])->name('italia-gira-banda');
Route::get('/corsi-di-musica', [PageController::class, 'corsiDiMusica'])->name('corsi-di-musica');
Route::get('/privacy-policy', [PageController::class, 'privacyPolicy'])->name('privacy-policy');

// Events
Route::get('/eventi', [EventController::class, 'index'])->name('eventi');
Route::get('/eventi/{slug}', [EventController::class, 'show'])->name('eventi.show');

// Gallery
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');
Route::get('/gallery/{slug}', [GalleryController::class, 'show'])->name('gallery.album');

// Contact
Route::get('/contatti', [ContactController::class, 'index'])->name('contatti');
Route::post('/contatti', [ContactController::class, 'store'])->name('contatti.store');

// Language switcher
Route::get('/language/{locale}', [LanguageController::class, 'switch'])->name('language.switch');
