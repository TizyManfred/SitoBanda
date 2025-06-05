/**
 * Admin JavaScript
 * 
 * Main JavaScript file for the SitoBanda admin area
 * Handles UI interactions, AJAX requests, and dashboard functionality
 * Following best practices for performance and accessibility
 */

document.addEventListener('DOMContentLoaded', function() {
    'use strict';
    
    // Initialize variables and cache DOM elements
    const body = document.body;
    const sidebar = document.querySelector('.sidebar');
    const mainContent = document.querySelector('.main-content');
    const navbar = document.querySelector('.navbar-admin');
    const sidebarToggle = document.querySelector('.sidebar-toggle');
    
    /**
     * UI Enhancement Functions
     * These functions improve the user experience and accessibility
     */
    
    // Initialize Bootstrap components with accessibility enhancements
    function initBootstrapComponents() {
        // Initialize tooltips with a11y improvements
        $('[data-toggle="tooltip"]').tooltip({
            trigger: 'hover focus',
            container: 'body',
            boundary: 'window'
        });
        
        // Initialize popovers with a11y improvements
        $('[data-toggle="popover"]').popover({
            trigger: 'focus',
            container: 'body',
            html: true,
            sanitize: false
        });
        
        // Make popovers dismissible by escape key
        $(document).on('keydown.popover', function(e) {
            if (e.key === 'Escape') {
                $('[data-toggle="popover"]').popover('hide');
            }
        });
        
        // Initialize Bootstrap custom file input
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            if (!fileName) fileName = 'Nessun file selezionato';
            
            const fileLabel = $(this).next('.custom-file-label');
            fileLabel.addClass('selected').html(fileName);
            fileLabel.attr('title', fileName);
            
            // Preview image if it's an image upload
            if (this.files && this.files[0]) {
                const file = this.files[0];
                // Check if file is an image
                if (file.type.match('image.*')) {
                    const reader = new FileReader();
                    const preview = $(this).closest('.form-group').find('.upload-preview');
                    
                    reader.onload = function(e) {
                        if (preview.length) {
                            preview.attr('src', e.target.result);
                            preview.attr('alt', 'Anteprima di ' + fileName);
                            preview.removeClass('d-none');
                        }
                    };
                    
                    reader.readAsDataURL(file);
                }
            }
        });
        
        // Auto-dismiss alerts after 5 seconds
        $('.alert-dismissible:not(.alert-important)').each(function() {
            const $alert = $(this);
            setTimeout(function() {
                $alert.alert('close');
            }, 5000);
        });
    }
    
    // Handle sidebar toggle and responsive behavior
    function setupSidebarToggle() {
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function(e) {
                e.preventDefault();
                body.classList.toggle('sidebar-collapsed');
                
                // Update aria attributes for accessibility
                const isCollapsed = body.classList.contains('sidebar-collapsed');
                sidebarToggle.setAttribute('aria-expanded', !isCollapsed);
                sidebar.setAttribute('aria-expanded', !isCollapsed);
                
                // Store sidebar state in localStorage
                localStorage.setItem('sidebarCollapsed', isCollapsed);
                
                // Update icon based on state
                const icon = sidebarToggle.querySelector('i');
                if (icon) {
                    if (isCollapsed) {
                        icon.classList.remove('fa-chevron-left');
                        icon.classList.add('fa-chevron-right');
                    } else {
                        icon.classList.remove('fa-chevron-right');
                        icon.classList.add('fa-chevron-left');
                    }
                }
            });
            
            // Check for stored sidebar state
            if (localStorage.getItem('sidebarCollapsed') === 'true') {
                body.classList.add('sidebar-collapsed');
                const icon = sidebarToggle.querySelector('i');
                if (icon) {
                    icon.classList.remove('fa-chevron-left');
                    icon.classList.add('fa-chevron-right');
                }
                sidebarToggle.setAttribute('aria-expanded', 'false');
                sidebar.setAttribute('aria-expanded', 'false');
            }
        }
        
        // Handle mobile sidebar behavior
        const mobileToggle = document.querySelector('.navbar-toggler');
        if (mobileToggle) {
            mobileToggle.addEventListener('click', function(e) {
                e.preventDefault();
                body.classList.toggle('sidebar-open');
            });
        }
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(e) {
            if (window.innerWidth < 768) {
                if (!e.target.closest('.sidebar') && 
                    !e.target.closest('.sidebar-toggle') &&
                    !e.target.closest('.navbar-toggler')) {
                    body.classList.remove('sidebar-open');
                }
            }
        });
    }
    
    // Setup dark mode toggle with preference detection
    function setupDarkModeToggle() {
        const darkModeToggle = document.querySelector('.mode-toggle');
        
        if (darkModeToggle) {
            // Check for system preference first, then stored preference
            const prefersDarkMode = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
            const storedPreference = localStorage.getItem('darkMode');
            
            if ((storedPreference === null && prefersDarkMode) || storedPreference === 'true') {
                body.classList.add('dark-mode');
                darkModeToggle.classList.add('active');
                darkModeToggle.setAttribute('aria-pressed', 'true');
                darkModeToggle.setAttribute('title', 'Passa alla modalità chiara');
            } else {
                darkModeToggle.setAttribute('aria-pressed', 'false');
                darkModeToggle.setAttribute('title', 'Passa alla modalità scura');
            }
            
            darkModeToggle.addEventListener('click', function() {
                body.classList.toggle('dark-mode');
                const isDarkMode = body.classList.contains('dark-mode');
                
                // Update UI and accessibility attributes
                this.classList.toggle('active');
                this.setAttribute('aria-pressed', isDarkMode);
                this.setAttribute('title', isDarkMode ? 'Passa alla modalità chiara' : 'Passa alla modalità scura');
                
                // Store theme preference
                localStorage.setItem('darkMode', isDarkMode);
            });
            
            // Listen for system preference changes
            if (window.matchMedia) {
                window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function(e) {
                    if (localStorage.getItem('darkMode') === null) {
                        if (e.matches) {
                            body.classList.add('dark-mode');
                            darkModeToggle.classList.add('active');
                            darkModeToggle.setAttribute('aria-pressed', 'true');
                            darkModeToggle.setAttribute('title', 'Passa alla modalità chiara');
                        } else {
                            body.classList.remove('dark-mode');
                            darkModeToggle.classList.remove('active');
                            darkModeToggle.setAttribute('aria-pressed', 'false');
                            darkModeToggle.setAttribute('title', 'Passa alla modalità scura');
                        }
                    }
                });
            }
        }
    }
    
    /**
     * Data Handling Functions
     */
    
    // Generic AJAX request function
    function ajaxRequest(url, method, data, successCallback, errorCallback) {
        $.ajax({
            url: url,
            type: method,
            data: data,
            dataType: 'json',
            success: function(response) {
                if (typeof successCallback === 'function') {
                    successCallback(response);
                }
            },
            error: function(xhr, status, error) {
                if (typeof errorCallback === 'function') {
                    errorCallback(xhr, status, error);
                } else {
                    console.error('AJAX Error:', error);
                    showToast('Si è verificato un errore: ' + error, 'danger');
                }
            }
        });
    }
    
    // Handle task list checkboxes
    function setupTaskCheckboxes() {
        $('.custom-checkbox input[type="checkbox"]').on('change', function() {
            const label = $(this).next('label');
            const taskId = $(this).attr('id').replace('task', '');
            
            if ($(this).is(':checked')) {
                label.html('<s>' + label.text() + '</s>');
                
                // In a real app, you would update the task status via AJAX
                // ajaxRequest('tasks/update.php', 'POST', { id: taskId, completed: 1 }, function(response) {
                //     showToast('Attività completata!', 'success');
                // });
            } else {
                label.html(label.text());
                
                // In a real app, you would update the task status via AJAX
                // ajaxRequest('tasks/update.php', 'POST', { id: taskId, completed: 0 }, function(response) {
                //     showToast('Attività riaperta!', 'info');
                // });
            }
        });
    }
    
    // Handle form submissions with AJAX
    function setupAjaxForms() {
        $('.ajax-form').on('submit', function(e) {
            e.preventDefault();
            
            const form = $(this);
            const submitBtn = form.find('[type="submit"]');
            const originalBtnText = submitBtn.html();
            const url = form.attr('action');
            const method = form.attr('method') || 'POST';
            const formData = new FormData(this);
            
            // Change button state to loading
            submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Elaborazione...');
            
            $.ajax({
                url: url,
                type: method,
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    // Reset button state
                    submitBtn.prop('disabled', false).html(originalBtnText);
                    
                    if (response.success) {
                        showToast(response.message || 'Operazione completata con successo!', 'success');
                        
                        // Handle redirect if specified
                        if (response.redirect) {
                            setTimeout(function() {
                                window.location.href = response.redirect;
                            }, 1000);
                        }
                        
                        // Reset form if specified
                        if (response.resetForm) {
                            form[0].reset();
                        }
                    } else {
                        showToast(response.message || 'Si è verificato un errore!', 'danger');
                    }
                },
                error: function(xhr, status, error) {
                    // Reset button state
                    submitBtn.prop('disabled', false).html(originalBtnText);
                    
                    console.error('AJAX Error:', error);
                    showToast('Si è verificato un errore di comunicazione!', 'danger');
                }
            });
        });
    }
    
    // Handle delete confirmations
    function setupDeleteConfirmations() {
        $('.delete-btn').on('click', function(e) {
            e.preventDefault();
            
            const deleteLink = $(this).attr('href');
            const itemName = $(this).data('item-name') || 'questo elemento';
            
            if (confirm('Sei sicuro di voler eliminare ' + itemName + '? Questa azione non può essere annullata.')) {
                window.location.href = deleteLink;
            }
        });
    }
    
    /**
     * Utility Functions
     */
    
    // Toast notification function
    window.showToast = function(message, type = 'info') {
        const toastId = 'toast-' + Date.now();
        const toast = `
            <div id="${toastId}" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
                <div class="toast-header bg-${type} text-white">
                    <strong class="mr-auto">Notifica</strong>
                    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="toast-body">
                    ${message}
                </div>
            </div>
        `;
        
        $('.toast-container').append(toast);
        $(`#${toastId}`).toast('show');
        
        // Remove the toast when hidden
        $(`#${toastId}`).on('hidden.bs.toast', function() {
            $(this).remove();
        });
    };
    
    // Format date for display
    window.formatDate = function(dateString) {
        const options = { 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        };
        
        return new Date(dateString).toLocaleDateString('it-IT', options);
    };
    
    // Setup notifications dropdown interaction
    function setupNotificationsDropdown() {
        const notificationsDropdown = document.querySelector('#notificationsDropdown');
        const messagesDropdown = document.querySelector('#messagesDropdown');
        
        if (notificationsDropdown) {
            // Mark notifications as read when opened
            $(notificationsDropdown).on('shown.bs.dropdown', function() {
                const badge = this.querySelector('.badge-counter');
                if (badge) {
                    // Animate badge count reduction
                    const count = parseInt(badge.textContent);
                    if (count > 0) {
                        badge.classList.add('fade-out');
                        setTimeout(function() {
                            badge.textContent = '0';
                            badge.classList.remove('fade-out');
                        }, 500);
                    }
                }
            });
        }
        
        // Same for messages dropdown
        if (messagesDropdown) {
            $(messagesDropdown).on('shown.bs.dropdown', function() {
                const badge = this.querySelector('.badge-counter');
                if (badge && parseInt(badge.textContent) > 0) {
                    badge.classList.add('fade-out');
                }
            });
        }
    }
    
    // Initialize content animations
    function initContentAnimations() {
        // Add animations to cards and content blocks for smoother UX
        const animateElements = document.querySelectorAll('.card, .content-header, .page-description');
        
        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('fade-in');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1 });
            
            animateElements.forEach(el => {
                observer.observe(el);
            });
        } else {
            // Fallback for browsers that don't support IntersectionObserver
            animateElements.forEach(el => {
                el.classList.add('fade-in');
            });
        }
    }
    
    // Initialize all UI components
    function initUI() {
        initBootstrapComponents();
        setupSidebarToggle();
        setupDarkModeToggle();
        setupNotificationsDropdown();
        initContentAnimations();
        setupTaskCheckboxes();
        setupAjaxForms();
        setupDeleteConfirmations();
    }
    
    // Call initialization
    initUI();
    
    // Make functions available globally
    window.adminUI = {
        initBootstrapComponents,
        ajaxRequest
    };
});
