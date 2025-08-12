<?php

namespace App\Helpers;

use App\Models\Setting;

class SettingsHelper
{
    /**
     * Get contact information
     */
    public static function contactInfo(): array
    {
        return Setting::get('contact_info', [
            'phone' => '',
            'email' => '',
            'whatsapp' => '',
            'address' => ''
        ]);
    }

    /**
     * Get social media links
     */
    public static function socialLinks(): array
    {
        return Setting::get('social_links', [
            'facebook' => '',
            'youtube' => '',
            'instagram' => '',
            'spotify' => ''
        ]);
    }

    /**
     * Get courses information
     */
    public static function coursesInfo(): array
    {
        return Setting::get('courses_info', [
            'start_date' => '',
            'end_date' => '',
            'expiration_date' => '',
            'contact_email' => '',
            'price' => '',
            'phone' => '',
            'forms_link' => '',
            'location' => '',
            'testimonials' => [
                [
                    'name' => '',
                    'text' => '',
                ]
            ]
        ]);
    }

    /**
     * Get site information
     */
    public static function siteInfo(): array
    {
        return Setting::get('site_info', [
            'title' => 'Banda Folk di Castello Tesino',
            'tagline' => 'Tradizione musicale dal 1901',
            'description' => '',
            'logo_url' => '/images/logo.png'
        ]);
    }

    /**
     * Get a specific contact field
     */
    public static function phone(): string
    {
        return self::contactInfo()['phone'] ?? '';
    }

    public static function email(): string
    {
        return self::contactInfo()['email'] ?? '';
    }

    public static function whatsapp(): string
    {
        return self::contactInfo()['whatsapp'] ?? '';
    }

    public static function address(): string
    {
        return self::contactInfo()['address'] ?? '';
    }

    /**
     * Get a specific social link
     */
    public static function facebookUrl(): string
    {
        return self::socialLinks()['facebook'] ?? '';
    }

    public static function youtubeUrl(): string
    {
        return self::socialLinks()['youtube'] ?? '';
    }

    public static function instagramUrl(): string
    {
        return self::socialLinks()['instagram'] ?? '';
    }

    public static function spotifyUrl(): string
    {
        return self::socialLinks()['spotify'] ?? '';
    }

    /**
     * Get courses contact email
     */
    public static function coursesEmail(): string
    {
        return self::coursesInfo()['contact_email'] ?? '';
    }

    /**
     * Get site title
     */
    public static function siteTitle(): string
    {
        return self::siteInfo()['title'] ?? 'Banda Folk di Castello Tesino';
    }

    /**
     * Get site tagline
     */
    public static function siteTagline(): string
    {
        return self::siteInfo()['tagline'] ?? '';
    }
}
