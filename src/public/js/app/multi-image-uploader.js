function multiImageUploaderComponent(config) {

    return {
        images: [],
        dragOver: false,
        statePath: config.statePath,
        maxFiles: config.maxFiles,
        acceptedFileTypes: config.acceptedFileTypes,
        maxSize: config.maxSize,
        locales: config.locales,
        processingMessage: config.processingMessage || 'Processing images...',
        isDisabled: false,
        _batching: false,
        translatingCaptions: {},
        // Track how many FileReader operations are in-flight
        _pendingReads: 0,

        init() {
            try {
                this.images = this.processInitialState(config.state);
                // Initialize drag-and-drop after DOM paints
                if (this.$nextTick) {
                    this.$nextTick(() => { this.setupSortable(); });
                } else {
                    setTimeout(() => { this.setupSortable(); }, 0);
                }
            } catch (error) {
                console.error('Error in init():', error);
                console.error('Full error stack:', error.stack);
                this.images = [];
            }
        },

        processInitialState(state) {
            if (!Array.isArray(state)) {
                return [];
            }
            
            try {
                const processed = [];
                for (let index = 0; index < state.length; index++) {
                    const item = state[index];
                    
                    if (!item) {
                        continue;
                    }
                    
                    const processedItem = {
                        id: null,
                        url: null,
                        path: null,
                        captions: {},
                        uploading: false,
                        processing: false
                    };
                    
                    // Carefully assign each property with logging (normalize id to string)
                    if (item.id !== undefined && item.id !== null) {
                        processedItem.id = String(item.id);
                    } else {
                        processedItem.id = `existing-${index}`;
                    }
                    
                    // URL assignment
                    if (item.url) {
                        processedItem.url = item.url;
                    } else if (item.path) {
                        processedItem.url = item.path;
                    } else if (typeof item === 'string') {
                        processedItem.url = item;
                    }
                    
                    // Path assignment
                    if (item.path) {
                        processedItem.path = item.path;
                    } else if (typeof item === 'string') {
                        processedItem.path = item;
                    }
                    
                    // Process captions
                    try {
                        processedItem.captions = this.initializeCaptions(
                            (item.captions && typeof item.captions === 'object') ? item.captions : {}
                        );
                    } catch (captionError) {
                        console.error(`Error initializing captions for item ${index}:`, captionError);
                        processedItem.captions = {};
                    }
                    
                    if (processedItem.id) {
                        processed.push(processedItem);
                    }
                }
                
                return processed;
            } catch (error) {
                console.error('Error in processInitialState():', error);
                console.error('Full error stack:', error.stack);
                return [];
            }
        },

        initializeCaptions(existingCaptions = {}) {
            const captions = {};
            
            if (!this.locales) {
                return captions;
            }
            
            try {
                Object.keys(this.locales).forEach(locale => {
                    if (existingCaptions && typeof existingCaptions === 'object' && existingCaptions[locale]) {
                        captions[locale] = existingCaptions[locale];
                    } else {
                        captions[locale] = '';
                    }
                });
                return captions;
            } catch (error) {
                console.error('Error in initializeCaptions():', error);
                console.error('Full error stack:', error.stack);
                return {};
            }
        },

        handleFileSelect(event) {
            try {
                const files = Array.from(event.target.files);
                this.processFiles(files);
                event.target.value = ''; // Reset input
            } catch (error) {
                console.error('Error in handleFileSelect():', error);
                console.error('Full error stack:', error.stack);
            }
        },

        handleDrop(event) {
            try {
                const files = Array.from(event.dataTransfer.files);
                this.processFiles(files);
            } catch (error) {
                console.error('Error in handleDrop():', error);
                console.error('Full error stack:', error.stack);
            }
        },

        processFiles(files) {
            let prevBatching = !!this._batching;
            try {
                this._batching = true;
                const remainingSlots = this.maxFiles - this.images.length;
                const filesToProcess = files.slice(0, remainingSlots);
                const validFiles = filesToProcess.filter(file => this.validateFile(file));

                if (validFiles.length > 0) {
                    this.dispatchFormEvent('form-processing-started', { message: this.processingMessage });
                }

                validFiles.forEach((file) => {
                    // Increment pending reads before adding, addImage will start FileReader
                    this._pendingReads++;
                    this.addImage(file);
                });
            } catch (error) {
                console.error('Error in processFiles():', error);
                console.error('Full error stack:', error.stack);
            } finally {
                // End batching; only sync state when all pending reads are done
                this._batching = prevBatching;
                const trySync = () => {
                    if (!this._batching && this._pendingReads <= 0) {
                        this.updateState();
                    }
                    this.refreshProcessingState();
                };
                // If no pending reads, sync immediately; otherwise onload/onerror will sync
                trySync();
            }
        },

        dispatchFormEvent(name, detail = {}) {
            try {
                this.$el.closest('form')?.dispatchEvent(new CustomEvent(name, {
                    composed: true,
                    cancelable: true,
                    detail,
                }));
            } catch (error) {
                console.error(`Error dispatching form event ${name}:`, error);
            }
        },

        refreshProcessingState() {
            if ((this._pendingReads || 0) > 0) {
                this.dispatchFormEvent('form-processing-started', { message: this.processingMessage });
                return;
            }

            this.dispatchFormEvent('form-processing-finished');
        },

        validateFile(file) {
            try {
                // Check file type
                if (!file.type.startsWith('image/')) {
                    this.showError('Only image files are allowed');
                    return false;
                }

                // Check file size
                if (file.size > this.maxSize * 1024) {
                    this.showError(`File size must be less than ${Math.round(this.maxSize/1024)}MB`);
                    return false;
                }
                return true;
            } catch (error) {
                console.error('Error in validateFile():', error);
                console.error('Full error stack:', error.stack);
                return false;
            }
        },

        addImage(file) {
            try {
                const imageId = `image-${Date.now()}-${Math.floor(Math.random() * 10000)}`;
                const reader = new FileReader();
                
                let imageUrl;
                try {
                    imageUrl = URL.createObjectURL(file);
                } catch (urlError) {
                    console.error('Error creating object URL:', urlError);
                    imageUrl = null;
                }

                const imageData = {
                    id: imageId,
                    file: file,
                    preview: null,
                    path: imageUrl, 
                    url: imageUrl,
                    captions: this.initializeCaptions(),
                    uploading: false,
                    processing: true
                };
                
                // Create new array and add the new item
                const newImagesArray = Array.isArray(this.images) ? [...this.images] : [];
                newImagesArray.push(imageData);
                this.images = newImagesArray;
                if (this.$nextTick) {
                    this.$nextTick(() => { this.setupSortable(); });
                }
                
                const finishProcessing = (preview) => {
                    try {
                        const image = this.images.find(img => img && img.id === imageId);
                        if (image) {
                            image.preview = preview || '';
                            image.processing = false;
                        }
                    } catch (error) {
                        console.error('Error finishing image processing:', error);
                    } finally {
                        this._pendingReads = Math.max(0, (this._pendingReads || 0) - 1);
                        if (!this._batching && this._pendingReads === 0) {
                            this.updateState();
                        }
                        this.refreshProcessingState();
                    }
                };

                // Build a compressed preview. The backend stores this data URL when no Livewire temp file exists.
                this.createOptimizedPreview(file).then(finishProcessing).catch((error) => {
                    console.error('Error optimizing image preview:', error);

                    reader.onload = (e) => {
                        finishProcessing(e.target.result);
                    };
                
                    reader.onerror = (readerError) => {
                        console.error('FileReader error:', readerError);
                        finishProcessing('');
                    };
                
                    try {
                        reader.readAsDataURL(file);
                    } catch (readError) {
                        console.error('Error reading file as data URL:', readError);
                        finishProcessing('');
                    }
                });
                
                // Do not update state here; processFiles() will perform a single batched update.
            } catch (error) {
                console.error('Error in addImage():', error);
                console.error('Full error stack:', error.stack);
            }
        },

        removeImage(index) {
            try {
                // Validate index
                if (typeof index !== 'number') {
                    console.error(`Invalid index type: ${typeof index}`);
                    return;
                }
                
                if (index < 0 || !this.images || index >= this.images.length) {
                    console.error(`Invalid index: ${index}, images length: ${this.images ? this.images.length : 'undefined'}`);
                    return;
                }
                
                // Clean up blob URL if needed
                const imageToRemove = this.images[index];
                if (imageToRemove && imageToRemove.url) {
                    if (typeof imageToRemove.url === 'string' && imageToRemove.url.startsWith('blob:')) {
                        try {
                            URL.revokeObjectURL(imageToRemove.url);
                        } catch (e) {
                            console.error('Error revoking URL:', e);
                            console.error('Error stack:', e.stack);
                        }
                    }
                }
                
                // Create a completely new array without the removed item
                const newImages = [];
                
                for (let i = 0; i < this.images.length; i++) {
                    const image = this.images[i];
                    
                    if (i === index) {
                        continue;
                    }
                    
                    if (!image) {
                        continue;
                    }
                    
                    if (!image.id) {
                        continue;
                    }
                    
                    newImages.push(image);
                }
                
                this.images = newImages;
                if (this.$nextTick) {
                    this.$nextTick(() => { this.setupSortable(); });
                } else {
                    setTimeout(() => { this.setupSortable(); }, 0);
                }
                
                this.updateState();
            } catch (error) {
                console.error('CRITICAL ERROR in removeImage():', error);
                console.error('Full error stack:', error.stack);
            }
        },

        async createOptimizedPreview(file) {
            const maxWidth = 1920;
            const maxHeight = 1920;
            const quality = 0.65;

            if (!file || !file.type || !file.type.startsWith('image/')) {
                return '';
            }

            const objectUrl = URL.createObjectURL(file);

            try {
                const image = await new Promise((resolve, reject) => {
                    const img = new Image();
                    img.onload = () => resolve(img);
                    img.onerror = reject;
                    img.src = objectUrl;
                });

                const ratio = Math.min(maxWidth / image.width, maxHeight / image.height, 1);
                const width = Math.max(1, Math.round(image.width * ratio));
                const height = Math.max(1, Math.round(image.height * ratio));
                const canvas = document.createElement('canvas');
                canvas.width = width;
                canvas.height = height;

                const context = canvas.getContext('2d');
                context.drawImage(image, 0, 0, width, height);

                return canvas.toDataURL('image/webp', quality);
            } finally {
                URL.revokeObjectURL(objectUrl);
            }
        },

        canTranslateCaption(index) {
            const image = this.images[index];

            if (!image || !image.captions) {
                return false;
            }

            return Object.values(image.captions).some(value => typeof value === 'string' && value.trim() !== '');
        },

        isTranslatingCaption(index) {
            const image = this.images[index];

            return !!(image && this.translatingCaptions && this.translatingCaptions[image.id]);
        },

        async translateCaption(index) {
            const image = this.images[index];

            if (!image || !image.captions || this.isTranslatingCaption(index)) {
                return;
            }

            const wire = this.$wire;

            if (!wire) {
                this.showError('Translation is not available right now');
                return;
            }

            this.translatingCaptions[image.id] = true;

            try {
                let translated = null;

                if (typeof wire.translateBulkUploadCaption === 'function') {
                    translated = await wire.translateBulkUploadCaption(image.captions);
                } else if (typeof wire.$call === 'function') {
                    translated = await wire.$call('translateBulkUploadCaption', image.captions);
                } else if (typeof wire.call === 'function') {
                    translated = await wire.call('translateBulkUploadCaption', image.captions);
                }

                if (translated && typeof translated === 'object') {
                    image.captions = this.initializeCaptions(translated);
                    this.updateState();
                }
            } catch (error) {
                console.error('Error translating caption:', error);
                this.showError('Unable to translate this caption');
            } finally {
                delete this.translatingCaptions[image.id];
            }
        },

        updateOrder(items) {
            try {
                // Validate inputs
                if (!Array.isArray(items)) {
                    console.error('items is not an array:', items);
                    return;
                }
                
                if (!Array.isArray(this.images)) {
                    console.error('this.images is not an array:', this.images);
                    return;
                }

                const newOrder = [];
                const seen = new Set();
                
                for (let i = 0; i < items.length; i++) {
                    const item = items[i];
                    const targetId = String(item);
                    if (seen.has(targetId)) {
                        continue; // dedupe in case ghost produced duplicates
                    }
                    seen.add(targetId);
                    const found = this.images.find(img => img && String(img.id) === targetId);
                    if (found) {
                        newOrder.push(found);
                    }
                }

                // If for any reason we missed some items (e.g., DOM query excluded them),
                // append them at the end in their current relative order to avoid loss.
                if (newOrder.length !== this.images.length) {
                    for (let i = 0; i < this.images.length; i++) {
                        const img = this.images[i];
                        const idStr = img && img.id != null ? String(img.id) : null;

                        if (!idStr) {
                            continue;
                        }

                        if (!seen.has(idStr)) {
                            seen.add(idStr);
                            newOrder.push(img);
                        }
                    }
                }

                // Preserve Alpine’s proxy identity by mutating the array in place
                this.images.splice(0, this.images.length, ...newOrder);
                this.updateState();

                // Wait for Alpine to render, then manually fix the DOM order to guarantee it matches the data
                if (this.$nextTick) {
                    this.$nextTick(() => {
                        const grid = this.$refs.grid;
                        if (!grid) return;

                        // Create a map of DOM elements by their ID for quick lookup
                        const elementMap = new Map();
                        grid.querySelectorAll('[data-id]').forEach(el => {
                            elementMap.set(el.dataset.id, el);
                        });

                        // Re-append elements to the grid in the correct order
                        newOrder.forEach(image => {
                            const element = elementMap.get(String(image.id));
                            if (element) {
                                grid.appendChild(element);
                            }
                        });
                    });
                }

            } catch (error) {
                console.error('Error in updateOrder():', error);
                console.error('Full error stack:', error.stack);
            }
        },

        // Removed index-based reordering per user's request

        setupSortable() {
            try {
                const grid = this.$refs && this.$refs.grid ? this.$refs.grid : null;
                if (!grid) return;
                if (!(window && window.Sortable)) return; // SortableJS not loaded

                // Destroy previous instance if any (avoid duplicates on re-init)
                if (this._sortable && typeof this._sortable.destroy === 'function') {
                    this._sortable.destroy();
                    this._sortable = null;
                }

                this._sortable = window.Sortable.create(grid, {
                    handle: '.drag-handle',
                    draggable: '[data-id]',
                    animation: 150,
                    ghostClass: 'opacity-50',
                    invertSwap: true,
                    swapThreshold: 0.5,
                    dataIdAttr: 'data-id',
                    onEnd: (evt) => {
                        try {
                            const ids = (this._sortable && typeof this._sortable.toArray === 'function')
                                ? this._sortable.toArray()
                                : Array.from(grid.querySelectorAll('[data-id]')).map(el => String(el.getAttribute('data-id'))).filter(Boolean);
                            this.updateOrder(ids);
                        } catch (e) {
                            console.error('Error computing new order:', e);
                        }
                    },
                });
            } catch (error) {
                console.error('Error in setupSortable():', error);
            }
        },

        updateState() {
            try {
                if (!this.images || !Array.isArray(this.images)) {
                    this.images = [];
                }
                
                // Filter out any undefined or null entries and create clean array
                const cleanImages = [];
                for (let i = 0; i < this.images.length; i++) {
                    const image = this.images[i];
                    if (image && image.id) {
                        cleanImages.push(image);
                    }
                }
                
                // Create a clean state object for each image
                const state = [];
                for (let i = 0; i < cleanImages.length; i++) {
                    const image = cleanImages[i];
                    try {
                        const stateItem = {
                            id: image.id,
                            path: image.path || '',
                            url: image.url || '',
                            file: image.file || null,
                            // Include preview so backend can handle base64 data URLs if needed
                            preview: image.preview || '',
                            processing: !!image.processing,
                            captions: image.captions || {}
                        };
                        state.push(stateItem);
                    } catch (itemError) {
                        console.error(`Error processing state item at index ${i}:`, itemError);
                    }
                }
                
                if (this.$wire && typeof this.$wire.set === 'function') {
                    try {
                        this.$wire.set(this.statePath, state);
                    } catch (e) {
                        console.error('Error stack:', e.stack);
                    }
                } else {
                    console.error('Cannot set state: $wire or $wire.set is not available');
                }
            } catch (error) {
                console.error('Error in updateState():', error);
                console.error('Full error stack:', error.stack);
            }
        },

        showError(message) {
            console.error('showError() called with message:', message);
            // Simple error display - can be enhanced with Filament notifications
            try {
                alert(message);
            } catch (error) {
                console.error('Error showing alert:', error);
            }
        }
    }
}
