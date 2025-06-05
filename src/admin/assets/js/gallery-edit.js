$(function () {
    const previewGridContainer = document.getElementById('sortable-photos');
    const addMoreBtn = document.getElementById('js-add-more');
    const albumForm = document.getElementById('album-form');
    const emptyGalleryMessage = document.getElementById('sortable-photos-empty');

    let filesState = []; // Holds { file: FileObject, src: URL, fields: {...}, existing: boolean, id: originalId, order: number, _toBeRemoved?: boolean }
    let sortable = null;
    let removedItems = []; // Tracks IDs of existing items that have been removed

    // --- Web Component: GalleryItemCard ---
    class GalleryItemCard extends HTMLElement {
        constructor() {
            super();
            this._item = null;
            this._idx = -1; // Current index in filesState
        }

        set item(value) {
            this._item = value;
            this._render();
        }

        get item() { return this._item; }

        set idx(value) {
            this._idx = value;
            // No automatic re-render on idx change alone, item change triggers it.
            // If direct re-render on idx change is needed, call this._render() here.
        }

        connectedCallback() {
            this._render();
        }

        _render() {
            if (!this._item) return;

            this.className = 'gallery-preview__item col-12 col-sm-6 col-md-4 col-lg-3 mb-3';
            this.innerHTML = ''; // Clear existing content

            const isExisting = this._item.existing === true;
            const inputIdSuffix = isExisting ? `_${this._item.id}` : `_new_${this._idx}`;
            const baseInputName = isExisting ? `existing_images[${this._item.id}]` : `new_images[${this._idx}]`;

            if (isExisting) {
                this.setAttribute('data-id', this._item.id);
            }
            // For easier debugging or specific selection if needed
            this.setAttribute('data-file-name', this._item.file ? this._item.file.name : (this._item.src || `item-${this._item.id || this._idx}`));

            const card = document.createElement('div');
            card.className = 'gallery-preview__thumb card h-100 d-flex flex-column position-relative';

            // Add drag handle button
            const dragHandle = document.createElement('button');
            dragHandle.type = 'button';
            dragHandle.className = 'btn btn-sm btn-secondary position-absolute top-0 start-0 m-1 gallery-preview__drag-handle';
            dragHandle.innerHTML = '<i class="fas fa-arrows-alt"></i>';
            dragHandle.setAttribute('aria-label', 'Trascina per riordinare');
            dragHandle.setAttribute('draggable', 'true');
            dragHandle.style.cursor = 'move';
            card.appendChild(dragHandle);

            const img = document.createElement('img');
            img.className = 'gallery-preview__img w-100';
            img.style.objectFit = 'cover';
            img.style.height = '180px';
            img.loading = 'lazy';
            img.alt = this._item.fields.title || 'Anteprima immagine';
            img.src = this._item.src; // src is pre-generated (URL.createObjectURL or existing URL)
            card.appendChild(img);

            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'btn btn-sm btn-danger position-absolute top-0 end-0 m-1 gallery-preview__remove';
            removeBtn.innerHTML = '<i class="fas fa-times"></i>';
            removeBtn.setAttribute('aria-label', 'Rimuovi immagine');
            removeBtn.style.right = '0';
            removeBtn.onclick = (e) => {
                e.stopPropagation(); // Prevent any parent click handlers
                const item = this._item;
                
                // Show confirmation dialog
                Swal.fire({
                    title: 'Conferma eliminazione',
                    text: 'Sei sicuro di voler eliminare questa immagine?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Sì, elimina',
                    cancelButtonText: 'Annulla'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Dispatch the remove event
                        this.dispatchEvent(new CustomEvent('gallery-item-removed', {
                            detail: { 
                                idx: this._idx, 
                                id: item.id, 
                                existing: item.existing,
                                filename: item.filename || (item.file ? item.file.name : '')
                            },
                            bubbles: true,
                            composed: true
                        }));
                    }
                });
            };
            card.appendChild(removeBtn);

            const caption = document.createElement('div');
            caption.className = 'gallery-preview__caption card-body p-2';

            // Title
            caption.appendChild(this._createInputGroup(`title${inputIdSuffix}`, 'Titolo', `${baseInputName}[title]`, this._item.fields.title, 'text', (e) => this._item.fields.title = e.target.value));

            // Description
            caption.appendChild(this._createInputGroup(`description${inputIdSuffix}`, 'Descrizione', `${baseInputName}[description]`, this._item.fields.description, 'textarea', (e) => this._item.fields.description = e.target.value));

            // Published Switch
            caption.appendChild(this._createSwitchGroup(`is_published${inputIdSuffix}`, 'Pubblicato', `${baseInputName}[is_published]`, this._item.fields.is_published, (e) => this._item.fields.is_published = e.target.checked));
            
            // Hidden order input (value updated during form submission prep)
            const orderInput = document.createElement('input');
            orderInput.type = 'hidden';
            orderInput.name = `${baseInputName}[order]`; 
            orderInput.value = this._item.order; 
            orderInput.classList.add('js-gallery-item-order');
            caption.appendChild(orderInput);

            card.appendChild(caption);
            this.appendChild(card);
        }

        _createInputGroup(id, labelText, name, value, type = 'text', onInputCallback) {
            const group = document.createElement('div');
            group.className = 'mb-2';
            const label = document.createElement('label');
            label.htmlFor = id;
            label.textContent = labelText;
            label.className = 'small form-label';
            group.appendChild(label);

            const input = type === 'textarea' ? document.createElement('textarea') : document.createElement('input');
            input.className = 'form-control form-control-sm';
            input.id = id;
            input.name = name;
            input.value = value || '';
            if (type !== 'textarea') input.type = type;
            else input.rows = 2;
            input.oninput = onInputCallback;
            group.appendChild(input);
            return group;
        }

        _createSwitchGroup(id, labelText, name, checked, onChangeCallback) {
            const group = document.createElement('div');
            group.className = 'form-check form-switch mb-0';
            const input = document.createElement('input');
            input.type = 'checkbox';
            input.className = 'form-check-input';
            input.id = id;
            input.name = name;
            input.value = '1'; // Standard value for checkbox when checked
            input.checked = !!checked;
            input.onchange = onChangeCallback;
            const label = document.createElement('label');
            label.className = 'form-check-label small';
            label.htmlFor = id;
            label.textContent = labelText;
            group.appendChild(input);
            group.appendChild(label);
            return group;
        }
    }

    if (!customElements.get('gallery-item-card')) {
        customElements.define('gallery-item-card', GalleryItemCard);
    }

    let mainHiddenFileInput = document.getElementById('images');
    if (!mainHiddenFileInput) {
        mainHiddenFileInput = document.createElement('input');
        mainHiddenFileInput.type = 'file';
        mainHiddenFileInput.id = 'images';
        mainHiddenFileInput.name = 'images[]'; // For NEW files
        mainHiddenFileInput.multiple = true;
        mainHiddenFileInput.accept = 'image/jpeg,image/png,image/webp';
        mainHiddenFileInput.style.display = 'none';
        if (albumForm) { albumForm.appendChild(mainHiddenFileInput); } else { console.error('Album form (#album-form) not found. Cannot append file input.'); }
    }

    if (addMoreBtn) {
        addMoreBtn.addEventListener('click', () => mainHiddenFileInput.click());
    }
    mainHiddenFileInput.addEventListener('change', (event) => {
        addFiles(event.target.files);
        event.target.value = ''; // Clear selection to allow re-adding same file if removed
    });

    // Handle form submission to include all files
    if (albumForm) {
        albumForm.addEventListener('submit', function(e) {
            // Create a temporary file input for the form
            const tempFileInput = document.createElement('input');
            tempFileInput.type = 'file';
            tempFileInput.name = 'images[]';
            tempFileInput.multiple = true;
            tempFileInput.style.display = 'none';
            
            // Create a DataTransfer object to hold the files
            const dataTransfer = new DataTransfer();
            
            // Add all files from filesState to the DataTransfer
            filesState.forEach(fileObj => {
                if (fileObj.file && !fileObj.existing) {
                    dataTransfer.items.add(fileObj.file);
                }
            });
            
            // Only proceed with file handling if there are files to upload
            if (dataTransfer.files.length > 0) {
                // Set the files to the temporary file input
                tempFileInput.files = dataTransfer.files;
                
                // Add the file input to the form
                this.appendChild(tempFileInput);
                
                // Log the files being submitted (for debugging)
                console.log('Submitting form with new files:', 
                    Array.from(dataTransfer.files).map(f => ({
                        name: f.name,
                        size: f.size,
                        type: f.type
                    }))
                );
            }
            
            // Add hidden fields for existing images
            document.querySelectorAll('[data-id]').forEach(item => {
                const id = item.getAttribute('data-id');
                if (!id || id === 'undefined') return;
                
                const title = item.querySelector('[name$="[title]"]')?.value || '';
                const description = item.querySelector('[name$="[description]"]')?.value || '';
                const isPublished = item.querySelector('[name$="[is_published]"]')?.checked ? '1' : '0';
                const order = item.querySelector('[name$="[order]"]')?.value || '0';
                
                // Add hidden fields for existing image
                addHiddenField(this, `existing_images[${id}][title]`, title);
                addHiddenField(this, `existing_images[${id}][description]`, description);
                addHiddenField(this, `existing_images[${id}][is_published]`, isPublished);
                addHiddenField(this, `order[${id}]`, order);
            });
            
            // Helper function to add hidden fields
            function addHiddenField(form, name, value) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = name;
                input.value = value;
                form.appendChild(input);
            }
        });
    }

    function addFiles(newFiles) {
        if (!newFiles || newFiles.length === 0) return;
        const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
        const currentFileNames = new Set(filesState.filter(item => item.file).map(item => item.file.name));

        Array.from(newFiles).forEach(file => {
            if (!allowedTypes.includes(file.type)) {
                console.warn(`Unsupported file type: ${file.name} (${file.type})`);
                return; // Skip
            }
            if (currentFileNames.has(file.name)) {
                console.warn(`Duplicate file skipped: ${file.name}`);
                return; // Skip duplicate
            }

            // Create a unique identifier for each file
            const fileId = 'file_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
            filesState.push({
                file: file,
                src: URL.createObjectURL(file),
                fields: { 
                    title: file.name.substring(0, file.name.lastIndexOf('.')) || '', 
                    description: '', 
                    is_published: true 
                },
                existing: false,
                id: fileId,
                order: filesState.length
            });
        });
        renderGrid();
    }

    function renderGrid() {
        if (!previewGridContainer) return;
        previewGridContainer.innerHTML = ''; // Clear

        if (filesState.length === 0 && emptyGalleryMessage) {
            emptyGalleryMessage.style.display = 'block';
        } else if (emptyGalleryMessage) {
            emptyGalleryMessage.style.display = 'none';
        }

        filesState.forEach((item, idx) => {
            item.order = idx; // Update order based on current array index
            const cardElement = document.createElement('gallery-item-card');
            cardElement.item = item; // This triggers _render in the component
            cardElement.idx = idx;
            previewGridContainer.appendChild(cardElement);
        });
        initializeSortable();
    }

    function initializeSortable() {
        if (!previewGridContainer) return;

        // Use SortableJS for drag and drop with handle
        new Sortable(previewGridContainer, {
            animation: 150,
            handle: '.gallery-preview__drag-handle',
            ghostClass: 'sortable-ghost',
            chosenClass: 'sortable-chosen',
            dragClass: 'sortable-drag',
            onStart: function(evt) {
                evt.item.style.opacity = '0.5';
            },
            onEnd: function(evt) {
                evt.item.style.opacity = '1';
                
                // Update the order of items in filesState
                const itemEl = evt.item;
                const fromIndex = evt.oldIndex;
                const toIndex = evt.newIndex;
                
                // Move the item in the array
                const [movedItem] = filesState.splice(fromIndex, 1);
                filesState.splice(toIndex, 0, movedItem);
                
                // Update the visual order
                renderGrid();
            }
        });
    }

    // Show toast notification
    function showToast(icon, title, text) {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });
        
        Toast.fire({
            icon: icon,
            title: title,
            text: text
        });
    }

    if (previewGridContainer) {
        previewGridContainer.addEventListener('gallery-item-removed', function(event) {
            const { idx, id, existing, filename } = event.detail;
            
            // Find the item in the current filesState
            const itemToRemove = filesState.find((item, index) => 
                index === idx || 
                (existing && item.id === id) || 
                (!existing && item.file && item.file.name === filename)
            );

            if (!itemToRemove) {
                console.error('Item to remove not found');
                return;
            }

            // If it's an existing item, add to removed items array
            if (existing && id) {
                if (!removedItems.includes(id)) {
                    removedItems.push(id);
                    // Add hidden input for removed items
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'removed_images[]';
                    input.value = id;
                    albumForm.appendChild(input);
                }
            }

            // Remove from filesState
            const itemIndex = filesState.indexOf(itemToRemove);
            if (itemIndex > -1) {
                filesState.splice(itemIndex, 1);
            }

            // Re-render the grid
            renderGrid();

            // Show success message if this was an existing item
            if (existing && id) {
                showToast('success', 'Immagine rimossa', 'L\'immagine è stata spostata nel cestino.');
            } else {
                showToast('info', 'Immagine rimossa', 'L\'immagine non salvata è stata rimossa.');
            }
            renderGrid();
        });

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            previewGridContainer.addEventListener(eventName, e => e.preventDefault(), false);
        });
        previewGridContainer.addEventListener('dragenter', () => previewGridContainer.classList.add('drag-over'));
        previewGridContainer.addEventListener('dragleave', () => previewGridContainer.classList.remove('drag-over'));
        previewGridContainer.addEventListener('drop', (event) => {
            previewGridContainer.classList.remove('drag-over');
            if (event.dataTransfer && event.dataTransfer.files) {
                addFiles(event.dataTransfer.files);
            }
        });
    }

    if (albumForm) {
        albumForm.setAttribute('enctype', 'multipart/form-data');
        albumForm.addEventListener('submit', function(e) {
            // Clear and re-populate the main file input for NEW files only
            const newFilesDataTransfer = new DataTransfer();
            let hasNewFiles = false;
            filesState.forEach((item, currentIdx) => {
                item.order = currentIdx; // Final order update
                if (item.file && !item.existing) {
                    newFilesDataTransfer.items.add(item.file);
                    hasNewFiles = true;
                }
                // Update hidden order inputs within cards
                const cardInDom = previewGridContainer.children[currentIdx];
                if (cardInDom) {
                    const orderInputInCard = cardInDom.querySelector('.js-gallery-item-order');
                    if (orderInputInCard) {
                        orderInputInCard.value = item.order;
                    }
                }
            });
            mainHiddenFileInput.files = hasNewFiles ? newFilesDataTransfer.files : new DataTransfer().files;
            
            // 'removed_images[]' are already added when items are removed.
            // All other metadata (title, desc, published, order for existing) is within the GalleryItemCard inputs.
            // console.log('Submitting form. filesState:', JSON.stringify(filesState, null, 2));
            // e.preventDefault(); // Uncomment for debugging
        });
    }

    // Initialize only once
    if (!window.galleryInitialized && previewGridContainer) {
        window.galleryInitialized = true; // Set flag to prevent double initialization
        
        console.log('Initializing existing photos');
        
        // Get all existing items from the PHP-rendered HTML
        const staticItems = Array.from(previewGridContainer.querySelectorAll('.gallery-preview__item[data-id]'));
        if (!staticItems.length) {
            console.log('No existing items found');
            return;
        }
        
        console.log('Found', staticItems.length, 'existing items');
        
        // Process each existing item
        staticItems.forEach(node => {
            const id = node.dataset.id;
            const imgEl = node.querySelector('img');
            const cap = node.querySelector('.gallery-preview__caption');
            
            if (!imgEl || !cap) {
                console.warn('Missing image or caption for item', id);
                return;
            }
            
            // Add to filesState with all necessary data
            filesState.push({
                existing: true,
                id: id,
                src: imgEl.src,
                fields: {
                    title: cap.querySelector('input[name^="existing_images["][name$="[title]"]')?.value || 
                           cap.querySelector('input[name^="title["]')?.value ||
                           '',
                    description: cap.querySelector('textarea[name^="existing_images["][name$="[description]"]')?.value || 
                                cap.querySelector('textarea[name^="description["]')?.value ||
                                '',
                    is_published: !!cap.querySelector('input[name^="existing_images["][name$="[is_published]"]:checked, input[name^="is_published["]:checked')
                },
                order: parseInt(cap.querySelector('input[name^="order["]')?.value || '0', 10)
            });
        });
        
        // Clear the container and re-render with our component
        previewGridContainer.innerHTML = '';
        renderGrid();
        
        console.log('Initialized', filesState.length, 'existing items');
    }
    
});
