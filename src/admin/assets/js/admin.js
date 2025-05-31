/**
 * Admin JavaScript
 * 
 * Main JavaScript file for the SitoBanda admin area
 * Handles UI interactions, AJAX requests, and dashboard functionality
 */

document.addEventListener('DOMContentLoaded', function() {
    'use strict';
    
    // Initialize variables and cache DOM elements
    const sidebar = document.querySelector('.sidebar');
    const mainContent = document.querySelector('.main-content');
    const sidebarToggleBtn = document.getElementById('sidebarToggle');
    
    /**
     * UI Enhancement Functions
     */
    
    // Initialize Bootstrap components
    function initBootstrapComponents() {
        // Initialize tooltips
        $('[data-toggle="tooltip"]').tooltip();
        
        // Initialize popovers
        $('[data-toggle="popover"]').popover();
        
        // Initialize Bootstrap custom file input
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass('selected').html(fileName);
            
            // Preview image if it's an image upload
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                const preview = $(this).closest('.form-group').find('.upload-preview');
                
                reader.onload = function(e) {
                    if (preview.length) {
                        preview.attr('src', e.target.result);
                    }
                };
                
                reader.readAsDataURL(this.files[0]);
            }
        });
    }
    
    // Handle sidebar toggle
    function setupSidebarToggle() {
        if (sidebarToggleBtn) {
            sidebarToggleBtn.addEventListener('click', function() {
                sidebar.classList.toggle('toggled');
                mainContent.classList.toggle('sidebar-toggled');
                
                // Store sidebar state in localStorage
                localStorage.setItem('sidebarToggled', sidebar.classList.contains('toggled'));
            });
            
            // Check for stored sidebar state
            if (localStorage.getItem('sidebarToggled') === 'true') {
                sidebar.classList.add('toggled');
                mainContent.classList.add('sidebar-toggled');
            }
        }
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(e) {
            if (window.innerWidth < 768) {
                if (!e.target.closest('.sidebar') && !e.target.closest('#sidebarToggle')) {
                    if (sidebar.classList.contains('toggled')) {
                        sidebar.classList.remove('toggled');
                        mainContent.classList.remove('sidebar-toggled');
                    }
                }
            }
        });
    }
    
    // Setup dark mode toggle
    function setupDarkModeToggle() {
        const darkModeToggle = document.querySelector('.mode-toggle');
        const body = document.body;
        
        if (darkModeToggle) {
            // Check for stored theme preference
            if (localStorage.getItem('darkMode') === 'true') {
                body.classList.add('dark-mode');
                darkModeToggle.classList.add('dark');
            }
            
            darkModeToggle.addEventListener('click', function() {
                body.classList.toggle('dark-mode');
                this.classList.toggle('dark');
                
                // Store theme preference
                localStorage.setItem('darkMode', body.classList.contains('dark-mode'));
            });
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
    
    // Initialize all UI components
    function initUI() {
        initBootstrapComponents();
        setupSidebarToggle();
        setupDarkModeToggle();
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
