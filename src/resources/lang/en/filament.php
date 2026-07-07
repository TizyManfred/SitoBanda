<?php

return [
    'navigation_groups' => [
        'system' => 'System',
        'content' => 'Content Management',
        'content_management' => 'Content Management',
    ],

    'navigation' => [
        'dashboard' => 'Dashboard',
        'settings' => 'Settings',
        'artisan_commands' => 'Artisan Commands',
        'analytics' => 'Analytics',
    ],

    'analytics' => [
        'not_set' => 'not set',
        'cards' => [
            'visitors_7d' => 'Visitors last 7 days',
            'pageviews_7d' => 'Pageviews last 7 days',
            'visitors_30d' => 'Visitors last 30 days',
            'pageviews_30d' => 'Pageviews last 30 days',
        ],
        'setup' => [
            'title' => 'Google Analytics configuration',
            'description' => 'This page reads GA4 data via the Spatie package and service account credentials.',
            'credentials_hint' => 'Credentials file path',
            'provider' => 'Provider',
            'measurement_id' => 'GA4 Measurement ID',
            'property_id' => 'GA4 Property ID',
            'credentials_file' => 'Credentials JSON',
        ],
        'traffic' => [
            'title' => 'Daily traffic',
            'description' => 'Visitor and pageview trend for the last 30 days.',
        ],
        'tables' => [
            'top_pages' => 'Top pages',
            'top_referrers' => 'Top referrers',
            'top_browsers' => 'Top browsers',
            'top_countries' => 'Top countries',
        ],
        'columns' => [
            'date' => 'Date',
            'visitors' => 'Visitors',
            'pageviews' => 'Pageviews',
            'page' => 'Page',
            'url' => 'URL',
            'referrer' => 'Referrer',
            'browser' => 'Browser',
            'country' => 'Country',
        ],
        'messages' => [
            'missing_configuration' => 'To view data you must set GA4 as provider, fill the GA4 Property ID, and upload the service account JSON file to the shown path.',
            'fetch_error' => 'Error while fetching analytics data.',
            'no_data' => 'No data available.',
        ],
    ],

    'artisan_commands' => [
        'navigation_label' => 'Artisan Commands',
    ],
];
