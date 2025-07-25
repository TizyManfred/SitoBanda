<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\SortableTrait;
use Spatie\Translatable\HasTranslations;

class GalleryItem extends Model
{
    use HasFactory, SoftDeletes, SortableTrait, HasTranslations;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'gallery_items';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public $translatable = [
        'caption',
    ];

    protected $fillable = [
        'album_id',
        'caption',
        'image_path',
        'is_featured',
        'taken_at',
        'sort_order',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_featured' => 'boolean',
        'taken_at' => 'datetime',
    ];

    public array $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true,
    ];

    /**
     * Get the album that the item belongs to.
     */
    public function album(): BelongsTo
    {
        return $this->belongsTo(GalleryAlbum::class, 'album_id');
    }
}
