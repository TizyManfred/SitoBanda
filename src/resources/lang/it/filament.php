<?php

return [
    // Navigation groups
    'navigation_groups' => [
        'system' => 'Sistema',
        'content' => 'Gestione Contenuti',
        'content_management' => 'Gestione Contenuti',
    ],

    // Resource labels
    'resources' => [
        'event' => 'Evento',
        'event_plural' => 'Eventi',
        'gallery_album' => 'Galleria',
        'gallery_album_plural' => 'Gallerie',
        'gallery_item' => 'Foto',
        'gallery_item_plural' => 'Foto',
        'user' => 'Utente',
        'user_plural' => 'Utenti',
        'section' => 'Organico',
        'section_plural' => 'Organico',
        'member' => 'Membro',
        'member_plural' => 'Membri',
        'contact' => 'Contatto',
        'contact_plural' => 'Contatti',
        'repertoire' => 'Repertorio',
        'repertoire_piece' => 'Brano Repertorio',
        'repertoire_piece_plural' => 'Brani Repertorio',
        'repertoire_program' => 'Programma Repertorio',
        'repertoire_program_plural' => 'Programmi Repertorio',
        'repertoire_year' => 'Anno Repertorio',
        'repertoire_year_plural' => 'Anni Repertorio',
        'static_page' => 'Pagina Statica',
        'static_page_plural' => 'Pagine Statiche',
    ],

    // Global navigation items
    'navigation' => [
        'dashboard' => 'Dashboard',
        'settings' => 'Impostazioni',
        'artisan_commands' => 'Comandi Artisan',
        'analytics' => 'Analytics',
    ],

    'homepage_static' => [
        'navigation_label' => 'Homepage',
        'title' => 'Homepage',
        'carousel_section' => 'Carosello header',
        'slides' => 'Slide',
        'add_slide' => 'Aggiungi slide',
        'slide_description' => 'Descrizione',
        'save' => 'Salva homepage',
        'saved' => 'Homepage salvata',
    ],

    'analytics' => [
        'not_set' => 'non impostato',
        'cards' => [
            'visitors_7d' => 'Visitatori ultimi 7 giorni',
            'pageviews_7d' => 'Pageview ultimi 7 giorni',
            'visitors_30d' => 'Visitatori ultimi 30 giorni',
            'pageviews_30d' => 'Pageview ultimi 30 giorni',
        ],
        'setup' => [
            'title' => 'Configurazione Google Analytics',
            'description' => 'Questa pagina legge i dati GA4 tramite il pacchetto Spatie e le credenziali service account.',
            'credentials_hint' => 'Percorso file credenziali',
            'provider' => 'Provider',
            'measurement_id' => 'GA4 Measurement ID',
            'property_id' => 'GA4 Property ID',
            'credentials_file' => 'Credentials JSON',
        ],
        'traffic' => [
            'title' => 'Traffico giornaliero',
            'description' => 'Andamento visitatori e pageview degli ultimi 30 giorni.',
        ],
        'tables' => [
            'top_pages' => 'Pagine più visitate',
            'top_referrers' => 'Referrer principali',
            'top_browsers' => 'Browser principali',
            'top_countries' => 'Paesi principali',
        ],
        'columns' => [
            'date' => 'Data',
            'visitors' => 'Visitatori',
            'pageviews' => 'Pageview',
            'page' => 'Pagina',
            'url' => 'URL',
            'referrer' => 'Referrer',
            'browser' => 'Browser',
            'country' => 'Paese',
        ],
        'messages' => [
            'missing_configuration' => 'Per vedere i dati devi impostare provider GA4, GA4 Property ID e caricare il file JSON del service account nel percorso indicato.',
            'fetch_error' => 'Errore durante il recupero dei dati analytics.',
            'no_data' => 'Nessun dato disponibile.',
        ],
    ],

    'artisan_commands' => [
        'navigation_label' => 'Comandi Artisan',
        'select_command' => 'Seleziona comando',
        'execute' => 'Esegui comando',
        'output' => 'Output comando:',
        'executed' => 'Comando eseguito correttamente',
        'empty_output' => 'Comando eseguito correttamente senza output',
        'error' => 'Errore durante l\'esecuzione del comando',
        'invalid_command' => 'Comando non consentito',
        'commands' => [
            'storage_link' => 'Crea link storage',
            'migrate' => 'Esegui migrazioni',
            'migrate_force' => 'Esegui migrazioni produzione',
            'optimize_clear' => 'Svuota cache',
            'package_discover' => 'Aggiorna discovery pacchetti',
            'view_clear' => 'Svuota cache viste',
            'config_clear' => 'Svuota cache configurazione',
            'route_clear' => 'Svuota cache rotte',
            'cache_clear' => 'Svuota cache applicazione',
            'lang_publish' => 'Pubblica lingue',
            'filament_assets' => 'Pubblica asset Filament',
            'filament_upgrade' => 'Esegui upgrade Filament',
            'filament_optimize_clear' => 'Svuota cache Filament',
            'filament_optimize' => 'Ottimizza Filament',
        ],
    ],
];
