<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;
use Illuminate\Support\Str;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class GalleryAlbum extends Model
{
    use HasFactory, SoftDeletes, HasTranslations;

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
            if ($model->isDirty('title') || !$model->exists) {
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
}
