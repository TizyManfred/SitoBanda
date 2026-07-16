<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'translation' => [
        'url' => env('TRANSLATION_URL'),
        'timeout' => env('TRANSLATION_TIMEOUT', 10),
    ],

    'nominatim' => [
        'endpoint' => env('NOMINATIM_ENDPOINT', 'https://nominatim.openstreetmap.org'),
        'user_agent' => env('NOMINATIM_USER_AGENT', 'SitoBanda/1.0 (+'.env('APP_URL', 'https://www.bandacastellotesino.it').')'),
        'email' => env('NOMINATIM_EMAIL'),
        'timeout' => env('NOMINATIM_TIMEOUT', 10),
    ],

    'turnstile' => [
        'enabled' => env('TURNSTILE_ENABLED', env('APP_ENV', 'production') === 'production'),
        'site_key' => env('TURNSTILE_SITE_KEY'),
        'secret_key' => env('TURNSTILE_SECRET_KEY'),
    ],

    'artisan_commands' => [
        'enabled' => env('ARTISAN_COMMANDS_ENABLED', false),
        'allowed_emails' => env('ARTISAN_COMMANDS_ALLOWED_EMAILS', ''),
    ],

];
