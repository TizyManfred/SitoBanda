@php
    $record = $getRecord();
    $imagePath = $record ? $record->getRawOriginal('image_path') : null;
    $imageUrl = $imagePath ? \Illuminate\Support\Facades\Storage::url($imagePath) : null;
    $alt = $record->alt_text ?? 'Image preview';
@if ($imageUrl)
    <div class="relative">
        <img 
            src="{{ $imageUrl }}" 
            alt="{{ $alt }}" 
            class="max-w-full h-auto max-h-64 mx-auto rounded-lg shadow-md"
            style="max-height: 400px;"
        >
        <div class="mt-2 text-sm text-center text-gray-500">
            Current Image (Upload a new image below to replace)
        </div>
    </div>
@endif
