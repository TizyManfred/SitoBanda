<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Contact Information
        Setting::set('contact_info', [
            'phone' => '+39 0461 594123',
            'email' => 'info@bandafolkcastellotesino.it',
            'whatsapp' => '+39 347 1234567',
            'address' => 'Via Roma, 15 - 38053 Castello Tesino (TN), Italy'
        ], 'contact', 'Informazioni di contatto della banda');

        // Social Media Links
        Setting::set('social_links', [
            'facebook' => 'https://facebook.com/bandafolkcastellotesino',
            'youtube' => 'https://youtube.com/@bandafolkcastellotesino',
            'instagram' => 'https://instagram.com/bandafolkcastellotesino',
            'spotify' => 'https://open.spotify.com/artist/bandafolkcastellotesino'
        ], 'social', 'Link ai social media della banda');

        // Site Information
        Setting::set('site_info', [
            'title' => 'Banda Folk di Castello Tesino',
            'tagline' => 'Tradizione musicale dal 1901',
            'description' => 'La Banda Folk di Castello Tesino è un\'istituzione musicale che da oltre un secolo porta avanti la tradizione della musica popolare trentina.',
            'logo_url' => '/images/logo.png'
        ], 'general', 'Informazioni generali del sito');

        // Course Information
        Setting::set('courses_info', [
            'registration_open' => true,
            'start_date' => '2025-09-15',
            'end_date' => '2026-06-30',
            'expiration_date' => '2025-06-27',
            'contact_email' => 'corsi@bandafolkcastellotesino.it',
            'price' => '€150 per corso annuale',
            'phone' => '328 8111676',
            'forms_link' => 'https://forms.gle/jwNTtArZxtXogfgz7',
            'location' => 'Sede della Banda - Via Roma, 15, Castello Tesino'
        ], 'courses', 'Informazioni sui corsi di musica');

        // Event Settings
        Setting::set('event_settings', [
            'show_upcoming_events' => true,
            'events_per_page' => 6,
            'featured_events_count' => 3,
            'booking_email' => 'eventi@bandafolkcastellotesino.it'
        ], 'events', 'Impostazioni per la gestione eventi');

        // Media Settings
        Setting::set('media_settings', [
            'gallery_items_per_page' => 12,
            'max_image_size' => '5MB',
            'allowed_formats' => ['jpg', 'jpeg', 'png', 'webp'],
            'enable_downloads' => false
        ], 'media', 'Impostazioni per gallery e media');
    }
}
