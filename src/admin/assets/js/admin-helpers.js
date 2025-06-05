/**
 * Admin Helper Scripts
 * Utility functions for admin area
 */

// Toast notification helper
function showToast(message, type = 'info', duration = 5000) {
    const bgClass = type === 'success' ? 'bg-success' : 
                   type === 'warning' ? 'bg-warning' :
                   type === 'danger' ? 'bg-danger' : 'bg-info';
                   
    const icon = type === 'success' ? 'fa-check-circle' :
                type === 'warning' ? 'fa-exclamation-triangle' :
                type === 'danger' ? 'fa-exclamation-circle' : 'fa-info-circle';
                
    const title = type === 'success' ? 'Successo' :
                 type === 'warning' ? 'Attenzione' :
                 type === 'danger' ? 'Errore' : 'Informazione';
    
    // Create toast HTML
    const toastId = 'toast-' + Date.now();
    const toastHtml = `
        <div id="${toastId}" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="${duration}">
            <div class="toast-header ${bgClass} text-white">
                <i class="fas ${icon} mr-2"></i>
                <strong class="mr-auto">${title}</strong>
                <small>${new Date().toLocaleTimeString('it-IT')}</small>
                <button type="button" class="ml-2 mb-1 close text-white" data-dismiss="toast" aria-label="Chiudi">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body">
                ${message}
            </div>
        </div>
    `;
    
    // Add toast to container
    $('.toast-container').append(toastHtml);
    
    // Show toast
    $(`#${toastId}`).toast('show');
    
    // Remove from DOM after hiding
    $(`#${toastId}`).on('hidden.bs.toast', function() {
        $(this).remove();
    });
}

// Loading indicator helpers
function showLoadingIndicator(element) {
    $(element).addClass('position-relative').append(`
        <div class="overlay">
            <i class="fas fa-2x fa-sync-alt fa-spin"></i>
        </div>
    `);
}

function hideLoadingIndicator(element) {
    $(element).removeClass('position-relative').find('.overlay').remove();
}

// Date formatter helper
function formatDate(dateString, format = 'long') {
    const date = new Date(dateString);
    
    switch(format) {
        case 'long':
            return date.toLocaleDateString('it-IT', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        case 'short':
            return date.toLocaleDateString('it-IT');
        case 'time':
            return date.toLocaleTimeString('it-IT');
        default:
            return date.toLocaleDateString('it-IT') + ' ' + date.toLocaleTimeString('it-IT');
    }
}

// Dark mode toggle
$(document).ready(function() {
    $('#darkModeToggle').on('click', function() {
        const isDarkMode = $('body').hasClass('dark-mode');
        
        // Toggle dark mode class
        $('body').toggleClass('dark-mode');
        
        // Update icon
        const icon = $(this).find('i');
        if (isDarkMode) {
            icon.removeClass('fa-sun').addClass('fa-moon');
        } else {
            icon.removeClass('fa-moon').addClass('fa-sun');
        }
        
        // Save preference in cookie
        document.cookie = `darkMode=${!isDarkMode}; path=/; max-age=${60*60*24*365}`;
    });
});
