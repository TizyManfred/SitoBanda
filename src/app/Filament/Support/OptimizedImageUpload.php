<?php

namespace App\Filament\Support;

use Filament\Forms\Components\BaseFileUpload;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class OptimizedImageUpload
{
    public static function webp(string $directory, int $quality = 65, int $maxWidth = 1920, int $maxHeight = 1920): \Closure
    {
        return static function (BaseFileUpload $component, TemporaryUploadedFile $file) use ($directory, $quality, $maxWidth, $maxHeight): ?string {
            if (! $file->exists()) {
                return null;
            }

            $diskName = $component->getDiskName();
            $disk = Storage::disk($diskName);
            $mimeType = (string) $file->getMimeType();

            if (! str_contains($mimeType, 'image')) {
                return $file->storeAs(
                    $directory,
                    $component->getUploadedFileNameForStorage($file),
                    $diskName
                );
            }

            $image = Image::make($file->getRealPath());

            if (method_exists($image, 'orientate')) {
                $image->orientate();
            }

            if ($image->width() > $maxWidth || $image->height() > $maxHeight) {
                $image->resize($maxWidth, $maxHeight, function ($constraint): void {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            }

            $baseName = pathinfo($component->getUploadedFileNameForStorage($file), PATHINFO_FILENAME);
            $filename = Str::slug($baseName) ?: (string) Str::ulid();
            $path = trim($directory.'/'.$filename.'.webp', '/');

            if ($disk->exists($path)) {
                $path = trim($directory.'/'.$filename.'-'.Str::ulid().'.webp', '/');
            }

            $stored = $disk->put($path, (string) $image->encode('webp', $quality), [
                'visibility' => 'public',
            ]);

            if (! $stored || ! $disk->exists($path)) {
                throw new \RuntimeException("Image upload failed while writing {$path} to {$diskName} disk.");
            }

            return $path;
        };
    }
}
