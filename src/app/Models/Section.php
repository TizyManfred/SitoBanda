<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Spatie\Translatable\HasTranslations;

class Section extends Model
{
    use HasFactory, SoftDeletes, HasTranslations;

    public array $translatable = [
        'name',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sections';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'icon_class',
        'display_order',
    ];

    protected $casts = [
        'name' => 'array',
        'display_order' => 'integer',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */

    protected static function booted(): void
    {
        static::saving(function (Section $section) {
            $section->setTranslations('name', self::normalizeNameTranslations($section->getTranslations('name')));
        });
    }

    public function getDisplayName(?string $locale = null): ?string
    {
        $locale ??= app()->getLocale();
        $fallbackLocale = config('app.fallback_locale');
        $translations = self::normalizeNameTranslations($this->getTranslations('name'));

        return $translations[$locale]
            ?: $translations[$fallbackLocale]
            ?: collect($translations)->filter()->first()
            ?: null;
    }

    protected static function normalizeNameTranslations(mixed $value): array
    {
        $locales = array_keys(LaravelLocalization::getSupportedLocales());

        if ($locales === []) {
            $locales = [config('app.locale', 'it'), config('app.fallback_locale', 'en')];
        }

        $translations = [];

        foreach (array_unique($locales) as $locale) {
            $translations[$locale] = self::extractTranslationValue($value, $locale, $locales);
        }

        return $translations;
    }

    protected static function extractTranslationValue(mixed $value, string $locale, array $locales): string
    {
        if (is_string($value)) {
            $decoded = json_decode($value, true);

            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return self::extractTranslationValue($decoded, $locale, $locales);
            }

            return trim($value);
        }

        if (is_array($value)) {
            if (array_key_exists($locale, $value)) {
                return self::extractTranslationValue($value[$locale], $locale, $locales);
            }

            foreach ($locales as $fallbackLocale) {
                if (! array_key_exists($fallbackLocale, $value)) {
                    continue;
                }

                $normalized = self::extractTranslationValue($value[$fallbackLocale], $fallbackLocale, $locales);

                if ($normalized !== '') {
                    return $normalized;
                }
            }

            foreach ($value as $nestedValue) {
                $normalized = self::extractTranslationValue($nestedValue, $locale, $locales);

                if ($normalized !== '') {
                    return $normalized;
                }
            }
        }

        if (is_scalar($value)) {
            return trim((string) $value);
        }

        return '';
    }

    /**
     * Get the members for the section.
     */
    public function members(): HasMany
    {
        return $this->hasMany(Member::class);
    }

    /**
     * Get all images for the section.
     */
    public function images(): HasMany
    {
        return $this->hasMany(SectionImage::class)->orderBy('display_order', 'asc');
    }
}
