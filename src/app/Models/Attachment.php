<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class Attachment extends Model
{
    use HasTranslations;

    public $translatable = ['title', 'description'];

    protected $fillable = [
        'title',
        'description',
        'disk',
        'file_path',
        'mime_type',
        'size_bytes',
        'display_order',
        'is_public',
    ];

    protected $attributes = [
        'disk' => 'local',
        'display_order' => 0,
        'is_public' => true,
    ];

    protected $casts = [
        'size_bytes' => 'integer',
        'display_order' => 'integer',
        'is_public' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saving(function (Attachment $attachment): void {
            $attachment->refreshFileMetadata();
        });

        static::updated(function (Attachment $attachment): void {
            if (! $attachment->wasChanged(['disk', 'file_path'])) {
                return;
            }

            $originalDisk = $attachment->getOriginal('disk');
            $originalPath = $attachment->getOriginal('file_path');

            if ($originalDisk && $originalPath) {
                Storage::disk($originalDisk)->delete($originalPath);
            }
        });

        static::deleted(function (Attachment $attachment): void {
            Storage::disk($attachment->disk)->delete($attachment->file_path);
        });
    }

    public function attachable(): MorphTo
    {
        return $this->morphTo();
    }

    public function scopePublic(Builder $query): Builder
    {
        return $query->where('is_public', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('display_order')->orderBy('id');
    }

    public function displayTitle(?string $locale = null): string
    {
        $locale ??= app()->getLocale();
        $title = $this->getTranslation('title', $locale, false)
            ?: $this->getTranslation('title', 'it', false);

        return $title ?: Str::headline(pathinfo($this->file_path, PATHINFO_FILENAME));
    }

    public function url(): string
    {
        return route('attachments.download', $this);
    }

    public function isPubliclyAvailable(): bool
    {
        if (! $this->is_public || ! $this->attachable) {
            return false;
        }

        if (method_exists($this->attachable, 'trashed') && $this->attachable->trashed()) {
            return false;
        }

        foreach (['is_public', 'is_active'] as $visibilityAttribute) {
            if (
                array_key_exists($visibilityAttribute, $this->attachable->getAttributes())
                && ! $this->attachable->getAttribute($visibilityAttribute)
            ) {
                return false;
            }
        }

        return true;
    }

    public function extension(): string
    {
        return Str::upper(pathinfo($this->file_path, PATHINFO_EXTENSION));
    }

    public function humanReadableSize(): ?string
    {
        if ($this->size_bytes === null) {
            return null;
        }

        $units = ['B', 'KB', 'MB', 'GB'];
        $size = (float) $this->size_bytes;
        $unit = 0;

        while ($size >= 1024 && $unit < count($units) - 1) {
            $size /= 1024;
            $unit++;
        }

        return number_format($size, $unit === 0 ? 0 : 1).' '.$units[$unit];
    }

    private function refreshFileMetadata(): void
    {
        if (! $this->file_path || ! Storage::disk($this->disk)->exists($this->file_path)) {
            return;
        }

        $this->mime_type = Storage::disk($this->disk)->mimeType($this->file_path);
        $this->size_bytes = Storage::disk($this->disk)->size($this->file_path);
    }
}
