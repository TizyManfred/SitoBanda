/**
 * Gallery JavaScript
 * 
 * Handles isotope filtering and lightGallery initialization
 * for the Band website gallery page
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize variables
    let grid = document.querySelector('.isotope');
    let filterButtons = document.querySelectorAll('.filter-button-group button');
    
    // Initialize Isotope grid after images are loaded
    imagesLoaded(grid, function() {
        // Initialize Isotope
        let iso = new Isotope(grid, {
            itemSelector: '.isotope-item',
            layoutMode: 'fitRows',
            percentPosition: true,
            masonry: {
                columnWidth: '.isotope-item'
            }
        });
        
        // Filter functions
        filterButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                let filterValue = this.getAttribute('data-filter');
                
                // Set active class on button
                filterButtons.forEach(function(btn) {
                    btn.classList.remove('active');
                });
                this.classList.add('active');
                
                // Filter items
                iso.arrange({
                    filter: filterValue
                });
                
                // Force layout update
                setTimeout(function() {
                    iso.layout();
                }, 300);
            });
        });
        
        // Set first button (All) as active by default
        if (filterButtons.length > 0) {
            filterButtons[0].classList.add('active');
        }
        
        // Initialize lightGallery
        lightGallery(grid, {
            selector: '[data-lightgallery="item"]',
            thumbnail: true,
            animateThumb: true,
            showThumbByDefault: false,
            share: false,
            download: false,
            autoplayControls: false,
            fullScreen: true,
            zoom: true,
            actualSize: false,
            getCaptionFromTitleOrAlt: true
        });
    });
    
    // Handle album section links
    const albumLinks = document.querySelectorAll('.box-icon-classic-title a');
    albumLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {
            // This will be implemented when album pages are created
            // For now, just scroll to the top of the gallery
            if (!this.href.includes('gallery-album.php')) {
                e.preventDefault();
                document.querySelector('.isotope').scrollIntoView({ behavior: 'smooth' });
                
                // Filter to the relevant category
                const category = this.getAttribute('href').split('=')[1];
                const correspondingButton = document.querySelector(`[data-filter=".${category}"]`);
                if (correspondingButton) {
                    correspondingButton.click();
                }
            }
        });
    });
    
    // Lazy loading for images
    if ('loading' in HTMLImageElement.prototype) {
        const images = document.querySelectorAll('img[loading="lazy"]');
        images.forEach(img => {
            img.src = img.dataset.src;
        });
    } else {
        // Fall back to a third-party lazy load library
        const script = document.createElement('script');
        script.src = 'https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js';
        document.body.appendChild(script);
    }
});

// Add imagesLoaded helper function if not available via plugin
if (typeof imagesLoaded !== 'function') {
    function imagesLoaded(container, callback) {
        let images = container.querySelectorAll('img');
        let count = images.length;
        
        if (count === 0) {
            callback();
            return;
        }
        
        let completed = 0;
        
        function check() {
            completed++;
            if (completed === count) {
                callback();
            }
        }
        
        images.forEach(function(img) {
            if (img.complete) {
                check();
            } else {
                img.addEventListener('load', check);
                img.addEventListener('error', check);
            }
        });
    }
}
