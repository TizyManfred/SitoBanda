/**
 * Admin UI Enhancements
 * 
 * JavaScript for enhanced UI interactions and animations
 * Following modern JavaScript best practices and accessibility guidelines
 */

// Wait for DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Initialize animations for content elements
    initContentAnimations();
    
    // Initialize staggered animations for list items
    initStaggeredAnimations();
    
    // Initialize toast system
    initToastSystem();
    
    // Set up accessible keyboard navigation enhancements
    enhanceKeyboardNavigation();
});

/**
 * Initialize IntersectionObserver for content animations
 */
function initContentAnimations() {
    // Target elements with data-animate attribute
    const animatableElements = document.querySelectorAll('[data-animate]');
    
    if (animatableElements.length === 0) return;
    
    // Check if IntersectionObserver is supported
    if ('IntersectionObserver' in window) {
        const animationObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // Get animation type from data attribute or default to fade-in
                    const animationType = entry.target.dataset.animate || 'fade-in';
                    entry.target.classList.add(animationType);
                    
                    // Stop observing after animation is applied
                    animationObserver.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1, // Trigger when at least 10% of the element is visible
            rootMargin: '0px 0px -50px 0px' // Adjust when animations trigger
        });
        
        // Start observing each element
        animatableElements.forEach(element => {
            animationObserver.observe(element);
        });
    } else {
        // Fallback for browsers that don't support IntersectionObserver
        animatableElements.forEach(element => {
            element.classList.add(element.dataset.animate || 'fade-in');
        });
    }
}

/**
 * Initialize staggered animations for list items
 */
function initStaggeredAnimations() {
    // Target elements with the stagger-container class
    const staggerContainers = document.querySelectorAll('.stagger-container');
    
    staggerContainers.forEach(container => {
        // Get all child items that should be staggered
        const items = container.querySelectorAll('.stagger-item');
        
        // Apply staggered animation class
        items.forEach((item, index) => {
            // Set delay based on index (this is also handled in CSS)
            setTimeout(() => {
                item.style.opacity = '1';
            }, 100 * index);
        });
    });
}

/**
 * Enhanced accessibility via keyboard navigation
 */
function enhanceKeyboardNavigation() {
    // Enhanced dropdown keyboard navigation
    const dropdowns = document.querySelectorAll('.dropdown');
    
    dropdowns.forEach(dropdown => {
        const toggle = dropdown.querySelector('.dropdown-toggle');
        const menu = dropdown.querySelector('.dropdown-menu');
        
        if (!toggle || !menu) return;
        
        // Enhance keyboard navigation for dropdowns
        toggle.addEventListener('keydown', function(e) {
            // Open dropdown and focus first item on arrow down
            if (e.key === 'ArrowDown' || e.key === 'Down') {
                e.preventDefault();
                $(toggle).dropdown('show');
                
                const firstItem = menu.querySelector('.dropdown-item');
                if (firstItem) firstItem.focus();
            }
        });
        
        // Add keyboard navigation within dropdown menu
        const dropdownItems = menu.querySelectorAll('.dropdown-item');
        
        dropdownItems.forEach((item, index) => {
            item.addEventListener('keydown', function(e) {
                // Move focus up/down the menu
                if (e.key === 'ArrowDown' || e.key === 'Down') {
                    e.preventDefault();
                    if (index < dropdownItems.length - 1) {
                        dropdownItems[index + 1].focus();
                    }
                } else if (e.key === 'ArrowUp' || e.key === 'Up') {
                    e.preventDefault();
                    if (index > 0) {
                        dropdownItems[index - 1].focus();
                    } else {
                        toggle.focus();
                        $(toggle).dropdown('hide');
                    }
                } else if (e.key === 'Escape' || e.key === 'Esc') {
                    e.preventDefault();
                    toggle.focus();
                    $(toggle).dropdown('hide');
                }
            });
        });
    });
    
    // Enhanced tab panel accessibility
    const tabLinks = document.querySelectorAll('[data-toggle="tab"]');
    
    tabLinks.forEach(tabLink => {
        tabLink.addEventListener('keydown', function(e) {
            // Move between tabs with arrow keys
            if (e.key === 'ArrowRight' || e.key === 'Right') {
                e.preventDefault();
                const nextTab = this.parentNode.nextElementSibling;
                if (nextTab) {
                    nextTab.querySelector('[data-toggle="tab"]').click();
                    nextTab.querySelector('[data-toggle="tab"]').focus();
                }
            } else if (e.key === 'ArrowLeft' || e.key === 'Left') {
                e.preventDefault();
                const prevTab = this.parentNode.previousElementSibling;
                if (prevTab) {
                    prevTab.querySelector('[data-toggle="tab"]').click();
                    prevTab.querySelector('[data-toggle="tab"]').focus();
                }
            }
        });
    });
    
    // Enhanced modal accessibility
    document.querySelectorAll('.modal').forEach(modal => {
        // Trap focus inside modal when open
        modal.addEventListener('shown.bs.modal', function() {
            trapFocusInModal(this);
        });
    });
}

/**
 * Trap focus inside modal for better accessibility
 * @param {HTMLElement} modal - The modal element to trap focus in
 */
function trapFocusInModal(modal) {
    const focusableElements = modal.querySelectorAll(
        'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
    );
    
    if (focusableElements.length === 0) return;
    
    const firstElement = focusableElements[0];
    const lastElement = focusableElements[focusableElements.length - 1];
    
    // Focus the first element when modal opens
    firstElement.focus();
    
    modal.addEventListener('keydown', function(e) {
        if (e.key === 'Tab') {
            // Shift+Tab on first element should loop to last element
            if (e.shiftKey && document.activeElement === firstElement) {
                e.preventDefault();
                lastElement.focus();
            }
            // Tab on last element should loop to first element
            else if (!e.shiftKey && document.activeElement === lastElement) {
                e.preventDefault();
                firstElement.focus();
            }
        }
    });
}

/**
 * Initialize the toast notification system
 */
function initToastSystem() {
    // Create toast container if it doesn't exist
    if (!document.querySelector('.toast-container')) {
        const toastContainer = document.createElement('div');
        toastContainer.className = 'toast-container';
        document.body.appendChild(toastContainer);
    }
    
    // Enhanced toast accessibility
    document.addEventListener('keydown', function(e) {
        // Close all toasts with Escape key
        if (e.key === 'Escape' || e.key === 'Esc') {
            const toasts = document.querySelectorAll('.toast.show');
            if (toasts.length > 0) {
                e.preventDefault();
                toasts.forEach(toast => {
                    toast.classList.remove('show');
                    toast.classList.add('hide');
                    setTimeout(() => {
                        toast.remove();
                    }, 300);
                });
            }
        }
    });
}

// Create card interactions
document.querySelectorAll('.card-interactive').forEach(card => {
    card.addEventListener('mouseenter', function() {
        this.classList.add('shadow-lg');
    });
    
    card.addEventListener('mouseleave', function() {
        this.classList.remove('shadow-lg');
    });
    
    // Add keyboard interaction for interactive cards
    card.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            // Simulate click if there's a main link in the card
            const cardLink = this.querySelector('a:first-child') || this.querySelector('button:first-child');
            if (cardLink) cardLink.click();
        }
    });
});

// Enhance form accessibility
document.querySelectorAll('.form-group').forEach(group => {
    const input = group.querySelector('input, select, textarea');
    const label = group.querySelector('label');
    
    if (input && label) {
        // Ensure input has proper ID for label association
        if (!input.id) {
            const uniqueId = 'input-' + Math.random().toString(36).substr(2, 9);
            input.id = uniqueId;
            label.htmlFor = uniqueId;
        }
        
        // Mark required fields visually
        if (input.required && !label.querySelector('.required-indicator')) {
            const requiredIndicator = document.createElement('span');
            requiredIndicator.className = 'required-indicator ml-1';
            requiredIndicator.textContent = '*';
            requiredIndicator.setAttribute('aria-hidden', 'true');
            label.appendChild(requiredIndicator);
            
            // Add screen reader text
            const srText = document.createElement('span');
            srText.className = 'sr-only';
            srText.textContent = '(obbligatorio)';
            label.appendChild(srText);
        }
    }
});

// Apply ARIA attributes to Bootstrap components
function enhanceBootstrapAccessibility() {
    // Make alerts dismissible by keyboard
    document.querySelectorAll('.alert .close').forEach(closeBtn => {
        closeBtn.setAttribute('aria-label', 'Chiudi');
        closeBtn.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                this.click();
            }
        });
    });
    
    // Make carousel controls more accessible
    document.querySelectorAll('.carousel').forEach(carousel => {
        const prevBtn = carousel.querySelector('.carousel-control-prev');
        const nextBtn = carousel.querySelector('.carousel-control-next');
        
        if (prevBtn) prevBtn.setAttribute('aria-label', 'Slide precedente');
        if (nextBtn) nextBtn.setAttribute('aria-label', 'Slide successiva');
    });
}

// Call on page load
enhanceBootstrapAccessibility();

// Re-apply enhancements when content is dynamically loaded with AJAX
document.addEventListener('content-loaded', function() {
    initContentAnimations();
    initStaggeredAnimations();
    enhanceBootstrapAccessibility();
    enhanceKeyboardNavigation();
});
