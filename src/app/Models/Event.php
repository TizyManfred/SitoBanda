<?php

namespace App\Models;

use App\Models\Traits\HasAttachments;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Spatie\Translatable\HasTranslations;

class Event extends Model
{
    use HasAttachments, HasFactory, HasTranslations, SoftDeletes;

    /**
     * The translatable attributes.
     *
     * @var array<int, string>
     */
    public $translatable = ['title', 'description', 'short_description', 'slug'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'slug',
        'description',
        'short_description',
        'location',
        'address',
        'latitude',
        'longitude',
        'start_datetime',
        'end_datetime',
        'gallery_id',
        'image_path',
        'is_featured',
        'is_public',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_datetime' => 'datetime',
        'end_datetime' => 'datetime',
        'is_featured' => 'boolean',
        'is_public' => 'boolean',
        'slug' => 'array',
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

                foreach ($locales as $locale => $properties) {
                    $title = $model->getTranslation('title', $locale);
                    $slugs[$locale] = Str::slug($title);
                }

                $model->slug = $slugs;
            }
        });
    }

    /**
     * Get the gallery album associated with the event.
     */
    public function galleryAlbum(): BelongsTo
    {
        return $this->belongsTo(GalleryAlbum::class, 'gallery_id');
    }

    /**
     * Scope a query to only include public events.
     */
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    /**
     * Scope a query to only include featured events.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope a query to only include upcoming events.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('start_datetime', '>', now());
    }

    /**
     * Scope a query to only include past events.
     */
    public function scopePast($query)
    {
        return $query->where('start_datetime', '<', now());
    }
}
