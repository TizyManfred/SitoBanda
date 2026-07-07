<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SectionImage extends Model
{
    protected $fillable = [
        'section_id',
        'gallery_item_id',
        'image_path',
        'caption',
        'display_order',
    ];

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function galleryItem(): BelongsTo
    {
        return $this->belongsTo(GalleryItem::class);
    }

    public function getResolvedImagePathAttribute(): ?string
    {
        return $this->galleryItem?->image_path ?: $this->image_path;
    }

    public function getResolvedCaptionAttribute(): ?string
    {
        return $this->caption ?: $this->galleryItem?->caption;
    }
}
