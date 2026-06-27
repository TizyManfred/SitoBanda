<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StaticPage extends Model
{
    use HasFactory;

    public const PAGE_OPTIONS = [
        'home_hero_1' => 'Homepage - slide 1',
        'home_hero_2' => 'Homepage - slide 2',
        'home_hero_3' => 'Homepage - slide 3',
        'chi_siamo' => 'Chi siamo',
        'storia' => 'Storia',
        'organico' => 'Organico',
        'maestro' => 'Maestro',
        'repertorio' => 'Repertorio',
        'abito_tradizionale' => 'Abito tradizionale',
        'italia_gira_banda' => 'Italia gira banda',
        'corsi_di_musica' => 'Corsi di musica',
        'events_index' => 'Eventi',
        'gallery_index' => 'Galleria',
        'contact' => 'Contatti',
    ];

    protected $fillable = [
        'page_key',
        'label',
        'route_name',
        'view_name',
        'admin_notes',
        'header_image_path',
        'fallback_header_image_path',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public static function headerImageUrl(string $pageKey, string $fallbackPath): string
    {
        try {
            return Cache::remember("static_page.header_image.{$pageKey}", 3600, function () use ($pageKey, $fallbackPath): string {
                $staticPage = static::query()
                    ->where('page_key', $pageKey)
                    ->where('is_active', true)
                    ->first();

                $path = $staticPage?->header_image_path
                    ?: $staticPage?->fallback_header_image_path
                    ?: $fallbackPath;

                return static::pathToUrl($path);
            });
        } catch (\Throwable) {
            return static::pathToUrl($fallbackPath);
        }
    }

    public function getHeaderImagePreviewUrlAttribute(): string
    {
        return static::pathToUrl($this->header_image_path ?: $this->fallback_header_image_path);
    }

    protected static function pathToUrl(?string $path): string
    {
        if (! filled($path)) {
            return asset('images/FotoSanIppolito1.webp');
        }

        if (Str::startsWith($path, ['http://', 'https://', '/', 'data:'])) {
            return $path;
        }

        if (Str::startsWith($path, 'images/')) {
            return asset($path);
        }

        return Storage::url($path);
    }

    protected static function booted(): void
    {
        static::saved(fn (self $staticPage) => static::clearCache($staticPage->page_key));
        static::deleted(fn (self $staticPage) => static::clearCache($staticPage->page_key));
    }

    protected static function clearCache(string $pageKey): void
    {
        Cache::forget("static_page.header_image.{$pageKey}");
    }
}
