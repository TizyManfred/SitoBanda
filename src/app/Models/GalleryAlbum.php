<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Spatie\Translatable\HasTranslations;

class GalleryAlbum extends Model
{
    use HasFactory, HasTranslations, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'gallery_albums';

    public $translatable = ['title', 'description', 'slug'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'slug',
        'description',
        'start_date',
        'end_date',
        'is_published',
        'view_count',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::saving(function ($model) {
            // Only update slug if the title has changed or if it's a new model
            if ($model->isDirty('title') || ! $model->exists) {
                $slugs = [];
                $locales = LaravelLocalization::getSupportedLocales();
                $existingSlugs = $model->getTranslations('slug');

                if (! is_array($existingSlugs)) {
                    $existingSlugs = [];
                }

                foreach ($locales as $locale => $properties) {
                    $title = $model->getTranslation('title', $locale);
                    $slug = Str::slug($title);

                    // Keep the previous slug for locales whose title cannot be
                    // transliterated (e.g. CJK scripts) instead of erasing it.
                    $slugs[$locale] = $slug !== '' ? $slug : (string) ($existingSlugs[$locale] ?? '');
                }

                $model->slug = $slugs;
            }
        });
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_published' => 'boolean',
        'slug' => 'array',
    ];

    /**
     * Get the items for the gallery album.
     */
    public function items(): HasMany
    {
        return $this->hasMany(GalleryItem::class, 'album_id');
    }

    /**
     * Get the event associated with the gallery album.
     */
    public function event(): HasOne
    {
        return $this->hasOne(Event::class, 'gallery_id');
    }
}
