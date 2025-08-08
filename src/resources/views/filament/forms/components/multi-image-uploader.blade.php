@php
    $id = $getId();
    $statePath = $getStatePath();
    $isDisabled = $isDisabled();
    $isRequired = $isRequired();
    $maxFiles = $getMaxFiles();
    $acceptedFileTypes = implode(',', $getAcceptedFileTypes());
    $maxSize = $getMaxSize();
    $locales = LaravelLocalization::getSupportedLocales();
    $state = $getState() ?? [];
    
    // Helper function to safely get translations
    function safeTranslate($key, $params = [], $default = '') {
        if (function_exists('__')) {
            return __($key, $params);
        } else {
            // Fallback to returning the key itself
            return $default ?: $key;
        }
    }
    
    $dragAndDropText = safeTranslate('fields.gallery.drag_and_drop', [], 'Drag and drop');
    $browseText = safeTranslate('fields.gallery.browse', [], 'browse');
    $maxFilesText = safeTranslate('fields.gallery.max_files', ['max' => $maxFiles], "Max files: {$maxFiles}");
    $maxSizeText = safeTranslate('fields.gallery.max_size', ['size' => round($maxSize/1024, 1)], "Max size: {round($maxSize/1024, 1)}MB");
    $uploadingText = safeTranslate('fields.gallery.uploading', [], 'Uploading');
    $captionsText = safeTranslate('fields.gallery.captions', [], 'Captions');
    $noImagesText = safeTranslate('fields.gallery.no_images', [], 'No images uploaded');
    $imageText = safeTranslate('fields.gallery.image', [], 'Image');
@endphp


<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <div
        wire:ignore
        x-load-js="[@js(\Filament\Support\Facades\FilamentAsset::getScriptSrc('multi-image-uploader'))]"
        x-data="multiImageUploaderComponent({
            state: @js($state),
            statePath: @js($statePath),
            maxFiles: @js($maxFiles),
            acceptedFileTypes: @js($acceptedFileTypes),
            maxSize: @js($maxSize),
            locales: @js($locales),
            dragOver: false,
        })"
        class="multi-image-uploader"
    >
        <!-- Upload Area -->
        <div class="mb-4">
            <div
                class="flex flex-col items-center justify-center space-y-2 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-6 text-center bg-gray-50 dark:bg-gray-800/20 hover:bg-gray-100 dark:hover:bg-gray-700 hover:border-gray-400 dark:hover:border-gray-500 transition-colors cursor-pointer" style="min-height: 160px;"
                @click="$refs.fileInput.click()"
                @dragover.prevent="dragOver = true"
                @dragleave.prevent="dragOver = false"
                @drop.prevent="handleDrop($event)"
                :class="{ 'border-primary-500 bg-primary-50 dark:bg-primary-900/20': dragOver }"
                
            >
                <div class="flex flex-col items-center">
                    <svg class="w-8 h-8 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        {{ $dragAndDropText }}
                        <span class="text-primary-600 dark:text-primary-400 underline">{{ $browseText }}</span>
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">
                        {{ $maxFilesText }} • {{ $maxSizeText }}
                    </p>
                </div>
            </div>

            <input
                type="file"
                x-ref="fileInput"
                multiple
                :accept="acceptedFileTypes"
                @change="handleFileSelect"
                class="hidden"
                {{ $isDisabled ? 'disabled' : '' }}
            />
        </div>

        <!-- Images Grid -->
        <div
            x-show="images.length > 0"
            class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4"
            x-ref="grid"
            wire:ignore
        >
            <template x-for="(image, index) in images" :key="String(image && image.id)">
                <div
                    class="relative bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden"
                    :data-id="String(image && image.id)"
                >
                    <!-- Card Header with Drag Handle -->
                    <div 
                        class="flex items-center justify-between bg-gray-50 dark:bg-gray-700/50 px-3 py-2 border-b border-gray-200 dark:border-gray-600"
                    >
                        <div class="flex items-center space-x-2">
                            <svg class="fi-icon-btn-icon h-5 w-5 cursor-move drag-handle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                                <path fill-rule="evenodd" d="M2.24 6.8a.75.75 0 0 0 1.06-.04l1.95-2.1v8.59a.75.75 0 0 0 1.5 0V4.66l1.95 2.1a.75.75 0 1 0 1.1-1.02l-3.25-3.5a.75.75 0 0 0-1.1 0L2.2 5.74a.75.75 0 0 0 .04 1.06Zm8 6.4a.75.75 0 0 0-.04 1.06l3.25 3.5a.75.75 0 0 0 1.1 0l3.25-3.5a.75.75 0 1 0-1.1-1.02l-1.95 2.1V6.75a.75.75 0 0 0-1.5 0v8.59l-1.95-2.1a.75.75 0 0 0-1.06-.04Z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        
                        <!-- Remove Button -->
                        <button
                            type="button"
                            @click="removeImage(index)"
                            class="text-red-500 hover:text-red-700 dark:hover:text-red-400 transition-colors"
                            :disabled="isDisabled"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Image Preview -->
                    <div class="aspect-square bg-gray-100 dark:bg-gray-700 relative">
                        <img
                            :src="image && image.preview ? image.preview : (image && image.url ? image.url : '')"
                            :alt="image && image.captions && image.captions.it ? image.captions.it : (image && image.captions && image.captions.en ? image.captions.en : 'Image')"
                            class="w-full object-cover"
                            style="aspect-ratio: 16/9;"
                            loading="lazy"
                        />

                        <!-- Loading Overlay -->
                        <div
                            x-show="image && image.uploading"
                            class="absolute inset-0 bg-black/50 flex items-center justify-center"
                        >
                            <div class="text-white text-sm">{{ $uploadingText }}...</div>
                        </div>

                        <!-- Captions Section -->
                        <div class="p-3 border-t border-gray-200 dark:border-gray-700">
                            <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ $captionsText }}
                            </h4>
                            
                            <!-- Multilingual Caption Inputs -->
                            <div class="space-y-2">
                                <template x-for="(locale, localeshort) in locales" :key="localeshort">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1" x-text="localeshort"></label>
                                        <input
                                            type="text"
                                            x-model="image.captions[localeshort]"
                                            @input.debounce.400ms="updateState()"
                                            class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:text-white"
                                            :placeholder="`Didascalia ${localeshort}...`"
                                            :disabled="isDisabled"
                                        />
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <!-- Empty State -->
        <div
            x-show="images.length === 0"
            class="text-center text-gray-500 dark:text-gray-400"
        >
            {{-- <svg class="w-4 h-4 mx-auto mb-3 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <p class="text-sm">{{ $noImagesText }}</p> --}}
        </div>
    </div>
</x-dynamic-component>
