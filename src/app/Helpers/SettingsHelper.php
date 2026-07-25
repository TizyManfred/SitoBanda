<?php

namespace App\Helpers;

use App\Models\Setting;
use Carbon\CarbonImmutable;

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
            'address' => '',
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
            'spotify' => '',
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
                ],
            ],
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
            'logo_url' => '/images/logo.png',
        ]);
    }

    /**
     * Get the editable and reusable homepage banner content.
     */
    public static function homeBanner(): array
    {
        $defaults = [
            'enabled' => true,
            'start_date' => null,
            'end_date' => null,
            'image' => null,
            'badge' => [],
            'headline' => [],
            'body' => [],
            'cta_label' => [],
            'cta_url' => [],
        ];

        foreach (array_keys(config('laravellocalization.supportedLocales', [])) as $locale) {
            $defaults['badge'][$locale] = trans('home.banner.badge', locale: $locale);
            $defaults['headline'][$locale] = trans('home.banner.headline', locale: $locale);
            $defaults['body'][$locale] = trans('home.banner.body', locale: $locale);
            $defaults['cta_label'][$locale] = trans('home.banner.cta', locale: $locale);
            $defaults['cta_url'][$locale] = trans('home.banner.cta_url', locale: $locale);
        }

        $settings = Setting::get('home_announcement_banner');

        if (! is_array($settings)) {
            $settings = Setting::get('home_anniversary_banner', []);
        }

        return array_replace_recursive($defaults, is_array($settings) ? $settings : []);
    }

    /**
     * Get the homepage banner content for one locale.
     */
    public static function localizedHomeBanner(?string $locale = null): array
    {
        $banner = self::homeBanner();
        $locale ??= app()->getLocale();
        $fallbackLocale = config('app.fallback_locale', 'it');
        $ctaUrl = self::exactBannerValue($banner['cta_url'] ?? [], $locale);

        return [
            'enabled' => (bool) ($banner['enabled'] ?? false),
            'visible' => self::isHomeBannerVisible($banner),
            'image' => is_string($banner['image'] ?? null) ? trim($banner['image']) : '',
            'badge' => self::localizedBannerValue($banner['badge'] ?? [], $locale, $fallbackLocale),
            'headline' => self::localizedBannerValue($banner['headline'] ?? [], $locale, $fallbackLocale),
            'body' => self::localizedBannerValue($banner['body'] ?? [], $locale, $fallbackLocale),
            'cta_label' => self::localizedBannerValue($banner['cta_label'] ?? [], $locale, $fallbackLocale),
            'cta_url' => self::sanitizeBannerUrl($ctaUrl),
        ];
    }

    /**
     * Get analytics settings
     */
    public static function analytics(): array
    {
        $defaults = [
            'enabled' => false,
            'provider' => 'none',
            'ga4_measurement_id' => '',
            'ga4_property_id' => '',
            'plausible_domain' => '',
            'plausible_script_url' => 'https://plausible.io/js/script.js',
        ];

        $settings = Setting::get('analytics_settings', []);

        return array_replace($defaults, is_array($settings) ? $settings : []);
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

    private static function localizedBannerValue(mixed $values, string $locale, string $fallbackLocale): string
    {
        if (is_string($values)) {
            return $values;
        }

        if (! is_array($values)) {
            return '';
        }

        $value = collect([
            $values[$locale] ?? null,
            $values[$fallbackLocale] ?? null,
            $values['it'] ?? null,
            ...array_values($values),
        ])
            ->first(fn ($value): bool => filled($value), '');

        return is_scalar($value) ? (string) $value : '';
    }

    private static function exactBannerValue(mixed $values, string $locale): string
    {
        if (is_string($values)) {
            return $values;
        }

        if (! is_array($values)) {
            return '';
        }

        $value = $values[$locale] ?? '';

        return is_scalar($value) ? (string) $value : '';
    }

    private static function isHomeBannerVisible(array $banner): bool
    {
        if (! (bool) ($banner['enabled'] ?? false)) {
            return false;
        }

        $now = CarbonImmutable::now();
        $startDate = self::parseBannerDate($banner['start_date'] ?? null)?->startOfDay();
        $endDate = self::parseBannerDate($banner['end_date'] ?? null)?->endOfDay();

        return (! $startDate || $now->greaterThanOrEqualTo($startDate))
            && (! $endDate || $now->lessThanOrEqualTo($endDate));
    }

    private static function parseBannerDate(mixed $value): ?CarbonImmutable
    {
        if (! is_string($value) || blank($value)) {
            return null;
        }

        try {
            return CarbonImmutable::parse($value, config('app.timezone'));
        } catch (\Throwable) {
            return null;
        }
    }

    private static function sanitizeBannerUrl(string $url): string
    {
        $url = trim($url);

        if (
            str_starts_with($url, '#')
            || (str_starts_with($url, '/') && ! str_starts_with($url, '//'))
        ) {
            return $url;
        }

        if (
            filter_var($url, FILTER_VALIDATE_URL)
            && in_array(parse_url($url, PHP_URL_SCHEME), ['http', 'https'], true)
        ) {
            return $url;
        }

        return '';
    }
}
