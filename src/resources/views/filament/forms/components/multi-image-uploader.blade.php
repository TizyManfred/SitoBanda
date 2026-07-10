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
    $translateText = safeTranslate('actions.translate', [], 'Traduci');
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
            processingMessage: @js($uploadingText . '...'),
            dragOver: false,
        })"
        class="multi-image-uploader"
    >
        <div
            x-show="_pendingReads > 0 || _pendingSyncs > 0"
            x-cloak
            role="status"
            aria-live="polite"
            class="mb-4 flex items-center gap-3 rounded-lg border border-primary-200 bg-primary-50 px-4 py-3 text-sm font-medium text-primary-700 dark:border-primary-500/30 dark:bg-primary-500/10 dark:text-primary-300"
        >
            <svg class="h-5 w-5 shrink-0 animate-spin" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <circle class="opacity-25" cx="12" cy="12" r="9" stroke="currentColor" stroke-width="3"></circle>
                <path class="opacity-80" fill="currentColor" d="M21 12a9 9 0 0 0-9-9v3a6 6 0 0 1 6 6h3Z"></path>
            </svg>
            <span>{{ $uploadingText }}... <span x-text="_pendingReads > 0 ? `(${_pendingReads})` : ''"></span></span>
        </div>

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
                    class="relative bg-white dark:bg-gray-900 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden"
                    :data-id="String(image && image.id)"
                >
                    <!-- Card Header with Drag Handle -->
                    <div 
                        class="flex items-center justify-between bg-gray-50 dark:bg-gray-800 px-3 py-2 border-b border-gray-200 dark:border-gray-700"
                    >
                        <div class="flex items-center space-x-2">
                            <svg class="fi-icon-btn-icon h-5 w-5 cursor-move drag-handle text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition-colors" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
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
                    <div class="aspect-square bg-gray-100 dark:bg-gray-800 relative">
                        <img
                            :src="image && image.preview ? image.preview : (image && image.url ? image.url : '')"
                            :alt="image && image.captions && image.captions.it ? image.captions.it : (image && image.captions && image.captions.en ? image.captions.en : 'Image')"
                            class="w-full object-cover"
                            style="aspect-ratio: 16/9;"
                            loading="lazy"
                        />

                        <!-- Loading Overlay -->
                        <div
                            x-show="image && (image.uploading || image.processing)"
                            class="absolute inset-0 bg-black/60 flex items-center justify-center"
                        >
                            <div class="text-white text-sm">{{ $uploadingText }}...</div>
                        </div>

                        <!-- Captions Section -->
                        <div class="p-3 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900">
                            <div class="mb-2 flex items-center justify-between gap-2">
                                <h4 class="text-sm font-medium text-gray-700 dark:text-gray-200">
                                    {{ $captionsText }}
                                </h4>
                                <button
                                    type="button"
                                    @click.stop="translateCaption(index)"
                                    :disabled="isDisabled || !canTranslateCaption(index) || isTranslatingCaption(index)"
                                    class="inline-flex items-center gap-1 rounded-md px-2 py-1 text-xs font-medium text-primary-600 hover:bg-primary-50 disabled:pointer-events-none disabled:opacity-50 dark:text-primary-400 dark:hover:bg-primary-400/10"
                                >
                                    <svg x-show="!isTranslatingCaption(index)" class="h-3.5 w-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m10.5 21 5.25-11.25L21 21m-9-3h7.5M3 5.25h12M9 3v2.25m1.048 8.697A18.022 18.022 0 0 1 6.412 9m6.088-3.75C11.813 7.5 10.5 9.75 8.625 12" />
                                    </svg>
                                    <svg x-show="isTranslatingCaption(index)" class="h-3.5 w-3.5 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 0 1 8-8v4a4 4 0 0 0-4 4H4z"></path>
                                    </svg>
                                    <span>{{ $translateText }}</span>
                                </button>
                            </div>
                            
                            <!-- Multilingual Caption Inputs -->
                            <div class="space-y-2">
                                <template x-for="(locale, localeshort) in locales" :key="localeshort">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1" x-text="localeshort"></label>
                                        <input
                                            type="text"
                                            x-model="image.captions[localeshort]"
                                            @input.debounce.400ms="syncState()"
                                            class="block w-full rounded-md border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm text-gray-900 shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:text-white dark:placeholder-gray-500"
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
