<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$basePath = dirname(__DIR__);

$app = Application::configure(basePath: $basePath)
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            /**** OTHER MIDDLEWARE ALIASES ****/
            'localize'                => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes::class,
            'localizationRedirect'    => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
            'localeSessionRedirect'   => \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
            'localeCookieRedirect'    => \Mcamara\LaravelLocalization\Middleware\LocaleCookieRedirect::class,
            'localeViewPath'          => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

$publicPath = $_SERVER['APP_PUBLIC_PATH'] ?? $_ENV['APP_PUBLIC_PATH'] ?? getenv('APP_PUBLIC_PATH') ?: null;

if (! is_string($publicPath) || $publicPath === '') {
    $envFile = $basePath.'/.env';

    if (is_readable($envFile)) {
        foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [] as $line) {
            if (str_starts_with(ltrim($line), 'APP_PUBLIC_PATH=')) {
                $publicPath = trim(substr(ltrim($line), strlen('APP_PUBLIC_PATH=')), " \t\n\r\0\x0B\"'");

                break;
            }
        }
    }
}

if (is_string($publicPath) && $publicPath !== '') {
    $isAbsolutePath = str_starts_with($publicPath, '/')
        || preg_match('/^[A-Za-z]:[\/\\\\]/', $publicPath) === 1;

    $app->usePublicPath($isAbsolutePath ? $publicPath : $basePath.'/'.$publicPath);
}

return $app;
