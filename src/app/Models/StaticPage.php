<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class StaticPage extends Model
{
    use HasFactory;
    use HasTranslations;

    public const PAGE_OPTIONS = [
        'home' => 'Homepage',
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
        'content_blocks',
        'content_html',
        'content_image_path',
        'content_images',
        'header_image_path',
        'header_images',
        'header_slides',
        'fallback_header_image_path',
        'is_active',
    ];

    public array $translatable = [
        'content_html',
    ];

    protected $casts = [
        'content_blocks' => 'array',
        'content_images' => 'array',
        'header_images' => 'array',
        'header_slides' => 'array',
        'is_active' => 'boolean',
    ];

    public static function homeCarouselSlides(): array
    {
        try {
            return Cache::remember('static_page.home_carousel_slides.' . app()->getLocale(), 3600, function (): array {
                $staticPage = static::query()
                    ->where('page_key', 'home')
                    ->where('is_active', true)
                    ->first();

                $slides = collect($staticPage?->header_slides ?? [])
                    ->map(fn (array $slide): ?array => static::normalizeHeaderSlide($slide))
                    ->filter()
                    ->values()
                    ->all();

                if ($slides !== []) {
                    return $slides;
                }

                $imageSlides = collect($staticPage?->header_images ?? [])
                    ->filter(fn (?string $path): bool => filled($path))
                    ->map(fn (string $path): array => [
                        'image_url' => static::pathToUrl($path),
                        'description' => null,
                    ])
                    ->values()
                    ->all();

                if ($imageSlides !== []) {
                    return $imageSlides;
                }

                return static::fallbackHomeCarouselSlides($staticPage);
            });
        } catch (\Throwable) {
            return static::fallbackHomeCarouselSlides();
        }
    }

    public static function contentBlocks(string $pageKey): array
    {
        try {
            return Cache::remember("static_page.content_blocks.{$pageKey}." . app()->getLocale(), 3600, function () use ($pageKey): array {
                $staticPage = static::query()
                    ->where('page_key', $pageKey)
                    ->where('is_active', true)
                    ->first();

                if (! $staticPage) {
                    return [];
                }

                $blocks = collect($staticPage->content_blocks ?? [])
                    ->map(fn (array $block): array => static::normalizeContentBlock($block))
                    ->filter(fn (array $block): bool => filled($block['title']) || filled($block['body']) || $block['images'] !== [])
                    ->values()
                    ->all();

                if ($blocks !== []) {
                    return $blocks;
                }

                if (filled($staticPage->content_html)) {
                    $images = collect(array_filter([
                        $staticPage->content_image_path,
                        ...($staticPage->content_images ?? []),
                    ]))
                        ->map(fn (string $path): array => [
                            'url' => static::pathToUrl($path),
                            'caption' => null,
                        ])
                        ->values()
                        ->all();

                    return [[
                        'title' => null,
                        'body' => $staticPage->content_html,
                        'images' => $images,
                        'layout' => 'text',
                    ]];
                }

                return [];
            });
        } catch (\Throwable) {
            return [];
        }
    }

    public static function contentHtml(string $pageKey): ?string
    {
        try {
            return Cache::remember("static_page.content_html.{$pageKey}." . app()->getLocale(), 3600, function () use ($pageKey): ?string {
                $staticPage = static::query()
                    ->where('page_key', $pageKey)
                    ->where('is_active', true)
                    ->first();

                return filled($staticPage?->content_html) ? $staticPage->content_html : null;
            });
        } catch (\Throwable) {
            return null;
        }
    }

    protected static function normalizeContentBlock(array $block): array
    {
        $images = static::normalizeContentBlockImages($block);

        return [
            'title' => static::localizedBlockText($block['title'] ?? null),
            'body' => static::localizedBlockText($block['body'] ?? null),
            'images' => $images,
            'layout' => $block['layout'] ?? 'text_image_right',
        ];
    }

    protected static function normalizeContentBlockImages(array $block): array
    {
        $imageItems = collect($block['image_items'] ?? [])
            ->map(function (array $imageItem): ?array {
                $path = $imageItem['image'] ?? null;

                if (is_array($path)) {
                    $path = collect($path)->first();
                }

                if (! filled($path)) {
                    return null;
                }

                return [
                    'url' => static::pathToUrl($path),
                    'caption' => static::localizedBlockText($imageItem['description'] ?? null),
                ];
            })
            ->filter()
            ->values()
            ->all();

        if ($imageItems !== []) {
            return $imageItems;
        }

        return collect($block['images'] ?? [])
            ->filter(fn (?string $path): bool => filled($path))
            ->map(fn (string $path): array => [
                'url' => static::pathToUrl($path),
                'caption' => null,
            ])
            ->values()
            ->all();
    }

    protected static function localizedBlockText(mixed $value): ?string
    {
        if (is_string($value)) {
            return filled($value) ? $value : null;
        }

        if (! is_array($value)) {
            return null;
        }

        $locale = app()->getLocale();
        $fallbackLocale = config('app.fallback_locale', 'it');

        return collect([
            $value[$locale] ?? null,
            $value[$fallbackLocale] ?? null,
            $value['it'] ?? null,
            ...array_values($value),
        ])
            ->first(fn ($text): bool => filled($text));
    }

    protected static function normalizeHeaderSlide(array $slide): ?array
    {
        $path = $slide['image'] ?? null;

        if (is_array($path)) {
            $path = collect($path)->first();
        }

        if (! filled($path)) {
            return null;
        }

        return [
            'image_url' => static::pathToUrl($path),
            'description' => static::localizedBlockText($slide['description'] ?? null),
        ];
    }

    protected static function fallbackHomeCarouselSlides(?self $staticPage = null): array
    {
        $fallbacks = [
            [
                'image' => 'images/FotoSanIppolito1.webp',
                'description' => '<h1><span class="d-block">' . e(__('home.hero.title')) . '</span><span class="d-block text-light">' . e(__('home.hero.subtitle')) . '</span></h1><p class="lead">' . __('home.hero.description') . '</p>',
            ],
            [
                'image' => 'images/FotoShanghai1.webp',
                'description' => '<h2>' . __('home.hero.slide2.title') . '</h2><p class="text-width-large">' . e(__('home.hero.slide2.text')) . '</p>',
            ],
            [
                'image' => 'images/FotoRoma1.webp',
                'description' => '<h2>' . __('home.hero.slide3.title') . '</h2><p class="text-width-large">' . e(__('home.hero.slide3.text')) . '</p>',
            ],
        ];

        return collect($fallbacks)
            ->map(function (array $fallback, int $index) use ($staticPage): array {
                $path = $staticPage?->header_images[$index] ?? null;
                $path = $path
                    ?: ($index === 0 ? $staticPage?->header_image_path : null)
                    ?: ($index === 0 ? $staticPage?->fallback_header_image_path : null)
                    ?: $fallback['image'];

                return [
                    'image_url' => static::pathToUrl($path),
                    'description' => $fallback['description'],
                ];
            })
            ->all();
    }

    public static function headerImageUrl(string $pageKey, string $fallbackPath, int $imageIndex = 0): string
    {
        try {
            return Cache::remember("static_page.header_image.{$pageKey}.{$imageIndex}", 3600, function () use ($pageKey, $fallbackPath, $imageIndex): string {
                $staticPage = static::query()
                    ->where('page_key', $pageKey)
                    ->where('is_active', true)
                    ->first();

                $slidePath = $staticPage?->header_slides[$imageIndex]['image'] ?? null;

                if (is_array($slidePath)) {
                    $slidePath = collect($slidePath)->first();
                }

                $path = $slidePath ?: ($staticPage?->header_images[$imageIndex] ?? null);
                $path = $path
                    ?: $staticPage?->header_image_path
                    ?: $staticPage?->fallback_header_image_path
                    ?: $fallbackPath;

                return static::pathToUrl($path);
            });
        } catch (\Throwable) {
            return static::pathToUrl($fallbackPath);
        }
    }

    public static function contentImageUrl(string $pageKey, string $fallbackPath, int $imageIndex = 0): string
    {
        try {
            return Cache::remember("static_page.content_image.{$pageKey}.{$imageIndex}", 3600, function () use ($pageKey, $fallbackPath, $imageIndex): string {
                $staticPage = static::query()
                    ->where('page_key', $pageKey)
                    ->where('is_active', true)
                    ->first();

                $path = $staticPage?->content_images[$imageIndex] ?? null;
                $path = $path
                    ?: ($imageIndex === 0 ? $staticPage?->content_image_path : null)
                    ?: $fallbackPath;

                return static::pathToUrl($path);
            });
        } catch (\Throwable) {
            return static::pathToUrl($fallbackPath);
        }
    }

    public function getHeaderImagePreviewUrlAttribute(): string
    {
        $path = $this->header_slides[0]['image'] ?? null;

        if (is_array($path)) {
            $path = collect($path)->first();
        }

        $path = $path ?: ($this->header_images[0] ?? null);

        return static::pathToUrl($path ?: $this->header_image_path ?: $this->fallback_header_image_path);
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
        foreach (['it', 'en', 'de'] as $locale) {
            Cache::forget("static_page.content_html.{$pageKey}.{$locale}");
            Cache::forget("static_page.content_blocks.{$pageKey}.{$locale}");
            Cache::forget("static_page.home_carousel_slides.{$locale}");
        }

        foreach (range(0, 9) as $index) {
            Cache::forget("static_page.header_image.{$pageKey}.{$index}");
            Cache::forget("static_page.content_image.{$pageKey}.{$index}");
        }
    }
}
