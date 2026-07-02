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
