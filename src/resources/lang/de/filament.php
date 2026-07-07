<?php

return [
    'navigation_groups' => [
        'system' => 'System',
        'content' => 'Inhaltsverwaltung',
        'content_management' => 'Inhaltsverwaltung',
    ],

    'navigation' => [
        'dashboard' => 'Dashboard',
        'settings' => 'Einstellungen',
        'artisan_commands' => 'Artisan-Befehle',
        'analytics' => 'Analytics',
    ],

    'analytics' => [
        'not_set' => 'nicht gesetzt',
        'cards' => [
            'visitors_7d' => 'Besucher letzte 7 Tage',
            'pageviews_7d' => 'Seitenaufrufe letzte 7 Tage',
            'visitors_30d' => 'Besucher letzte 30 Tage',
            'pageviews_30d' => 'Seitenaufrufe letzte 30 Tage',
        ],
        'setup' => [
            'title' => 'Google-Analytics-Konfiguration',
            'description' => 'Diese Seite liest GA4-Daten über das Spatie-Paket und die Service-Account-Anmeldedaten.',
            'credentials_hint' => 'Pfad zur Credentials-Datei',
            'provider' => 'Provider',
            'measurement_id' => 'GA4 Measurement ID',
            'property_id' => 'GA4 Property ID',
            'credentials_file' => 'Credentials JSON',
        ],
        'traffic' => [
            'title' => 'Täglicher Traffic',
            'description' => 'Verlauf von Besuchern und Seitenaufrufen der letzten 30 Tage.',
        ],
        'tables' => [
            'top_pages' => 'Beliebteste Seiten',
            'top_referrers' => 'Top-Referrer',
            'top_browsers' => 'Top-Browser',
            'top_countries' => 'Top-Länder',
        ],
        'columns' => [
            'date' => 'Datum',
            'visitors' => 'Besucher',
            'pageviews' => 'Seitenaufrufe',
            'page' => 'Seite',
            'url' => 'URL',
            'referrer' => 'Referrer',
            'browser' => 'Browser',
            'country' => 'Land',
        ],
        'messages' => [
            'missing_configuration' => 'Um Daten anzuzeigen, musst du GA4 als Provider setzen, die GA4 Property ID eintragen und die Service-Account-JSON-Datei in den angezeigten Pfad hochladen.',
            'fetch_error' => 'Fehler beim Abrufen der Analytics-Daten.',
            'no_data' => 'Keine Daten verfügbar.',
        ],
    ],

    'artisan_commands' => [
        'navigation_label' => 'Artisan-Befehle',
    ],
];
