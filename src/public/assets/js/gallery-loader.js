/**
 * Gallery Loader
 * JavaScript module to load gallery images dynamically from the scraper API
 */
(function () {
    'use strict';

    // DOM elements
    const galleryContainer = document.querySelector('.row.row-30.isotope');
    const loadingIndicator = document.createElement('div');
    const loadMoreButton = document.getElementById('load-more-gallery');
    const errorContainer = document.createElement('div');
    
    // State variables
    let currentPage = 1;
    let albumsPerPage = 6;
    let isLoading = false;
    let allAlbumsLoaded = false;
    let cachedData = null;

    /**
     * Initialize the gallery loader
     */
    function initGallery() {
        if (!galleryContainer) return;
        
        // Set up loading indicator
        loadingIndicator.className = 'text-center w-100 py-4';
        loadingIndicator.innerHTML = '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Caricamento...</span></div>';
        
        // Set up error container
        errorContainer.className = 'alert alert-danger w-100 my-4 d-none';
        errorContainer.role = 'alert';
        
        // Append containers
        galleryContainer.parentNode.insertBefore(errorContainer, galleryContainer.nextSibling);
        
        // Check if we should load from cache or API
        checkCache().then(cacheValid => {
            if (cacheValid) {
                loadFromCache();
            } else {
                refreshCache();
            }
        });

        // Set up load more button if it exists
        if (loadMoreButton) {
            loadMoreButton.addEventListener('click', function(e) {
                e.preventDefault();
                if (!isLoading && !allAlbumsLoaded) {
                    currentPage++;
                    renderGalleryItems();
                }
            });
        }
    }

    /**
     * Check if cache file exists and is valid (not older than 24 hours)
     */
    async function checkCache() {
        try {
            const response = await fetch('assets/data/gallery-cache.json', { 
                method: 'HEAD',
                cache: 'no-store'
            });
            
            if (!response.ok) return false;
            
            const lastModified = new Date(response.headers.get('Last-Modified'));
            const now = new Date();
            const cacheAge = now - lastModified;
            
            // Cache is valid if less than 24 hours old
            return cacheAge < 24 * 60 * 60 * 1000;
        } catch (error) {
            console.error('Error checking cache:', error);
            return false;
        }
    }

    /**
     * Load gallery data from cache file
     */
    async function loadFromCache() {
        try {
            showLoading(true);
            
            const response = await fetch('assets/data/gallery-cache.json', {
                cache: 'no-store'
            });
            
            if (!response.ok) {
                throw new Error('Cache file not found or invalid');
            }
            
            cachedData = await response.json();
            renderGalleryItems();
            
            showLoading(false);
        } catch (error) {
            console.error('Error loading from cache:', error);
            showError('Errore nel caricamento della galleria dalla cache. Aggiornamento in corso...');
            refreshCache();
        }
    }

    /**
     * Refresh cache by calling the scraper API
     */
    function refreshCache() {
        showLoading(true);
        
        fetch('bat/gallery-scraper.php?action=cache&limit=10')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to refresh gallery cache');
                }
                return response.json();
            })
            .then(data => {
                if (data.error) {
                    throw new Error(data.error);
                }
                
                // Load from the newly created cache
                loadFromCache();
            })
            .catch(error => {
                console.error('Error refreshing cache:', error);
                showError('Non è stato possibile caricare le immagini della galleria. Riprova più tardi.');
                showLoading(false);
            });
    }

    /**
     * Render gallery items from the cached data
     */
    function renderGalleryItems() {
        if (!cachedData || !Array.isArray(cachedData)) {
            showError('Dati della galleria non disponibili');
            return;
        }
        
        showLoading(true);
        
        // Calculate slice of albums to show based on current page
        const startIndex = (currentPage - 1) * albumsPerPage;
        const endIndex = startIndex + albumsPerPage;
        const albumsToShow = cachedData.slice(startIndex, endIndex);
        
        // Check if we've loaded all albums
        allAlbumsLoaded = endIndex >= cachedData.length;
        
        // Hide load more button if all albums are loaded
        if (loadMoreButton) {
            loadMoreButton.classList.toggle('d-none', allAlbumsLoaded);
        }
        
        // If this is the first page, clear the container
        if (currentPage === 1) {
            // Keep only static example items if they exist
            const staticItems = Array.from(galleryContainer.querySelectorAll('.isotope-item.static-item'));
            galleryContainer.innerHTML = '';
            staticItems.forEach(item => galleryContainer.appendChild(item));
        }
        
        // Create and add gallery items
        albumsToShow.forEach(album => {
            if (!album.photos || !album.photos.length) return;
            
            // Get first photo to use as album cover
            const coverPhoto = album.photos[0];
            
            // Determine the category filter
            let filterCategory;
            switch (album.category) {
                case 'Concerti': filterCategory = 'Category 1'; break;
                case 'Trasferte': filterCategory = 'Category 2'; break;
                case 'Sfilate': filterCategory = 'Category 3'; break;
                default: filterCategory = 'Category 1';
            }
            
            // Create gallery item
            const itemHtml = `
                <div class="col-sm-6 col-lg-4 isotope-item" data-filter="${filterCategory}">
                    <a class="gallery-item" href="${coverPhoto.url}" data-lightgallery="item">
                        <img src="${coverPhoto.thumbnail}" alt="${album.title}" width="370" height="303"/>
                        <div class="gallery-item-content">
                            <div class="heading-4 gallery-item-title">${album.location || ''} - ${album.event || ''}</div>
                            <p>${album.date || ''}</p>
                        </div>
                    </a>
                </div>
            `;
            
            // Add to gallery container
            galleryContainer.insertAdjacentHTML('beforeend', itemHtml);
        });
        
        // Initialize or update isotope
        if (window.jQuery && jQuery.fn.isotope) {
            jQuery(galleryContainer).isotope('reloadItems').isotope();
        }
        
        // Initialize or update lightgallery
        if (window.jQuery && jQuery.fn.lightGallery) {
            jQuery(galleryContainer).find('[data-lightgallery="item"]').lightGallery({
                selector: '[data-lightgallery="item"]',
                thumbnail: true,
                animateThumb: false,
                showThumbByDefault: false
            });
        }
        
        showLoading(false);
    }

    /**
     * Show or hide loading indicator
     */
    function showLoading(show) {
        isLoading = show;
        
        if (show) {
            if (!document.contains(loadingIndicator)) {
                galleryContainer.parentNode.insertBefore(loadingIndicator, galleryContainer.nextSibling);
            }
        } else {
            if (document.contains(loadingIndicator)) {
                loadingIndicator.remove();
            }
        }
    }

    /**
     * Show error message
     */
    function showError(message) {
        errorContainer.textContent = message;
        errorContainer.classList.remove('d-none');
        
        // Hide error after 5 seconds
        setTimeout(() => {
            errorContainer.classList.add('d-none');
        }, 5000);
    }

    // Initialize gallery when DOM is ready
    document.addEventListener('DOMContentLoaded', initGallery);
})();
