<?php
/**
 * Admin Footer Template - AdminLTE 3 Version
 *
 * Includes the closing HTML tags, JavaScript imports, and modal dialogs
 * Following PSR-12 coding standards and accessibility best practices
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}

// Check if it's the login page
$isLoginPage = basename($_SERVER['PHP_SELF']) === 'login.php';
?>
<?php if (!$isLoginPage): ?>
<?php endif; ?>

<!-- Toast Container for Notifications -->
<div class="toast-container position-fixed bottom-0 right-0 p-3"></div>

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="<?php echo SITE_URL; ?>/admin/assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo SITE_URL; ?>/admin/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Custom scripts -->
<script src="<?php echo SITE_URL; ?>/admin/assets/js/admin.js"></script>

<!-- AdminLTE App -->
<script src="<?php echo SITE_URL; ?>/admin/assets/adminlte/js/adminlte.min.js"></script>
<!-- Sortable.js for gallery photo reordering -->
<script src="<?php echo SITE_URL; ?>/admin/assets/plugins/sortablejs/Sortable.js"></script>
<!-- SimpleLightbox for gallery photo previews -->
<script src="<?php echo SITE_URL; ?>/admin/assets/plugins/simplelightbox/simple-lightbox.min.js"></script>
<link rel="stylesheet" href="<?php echo SITE_URL; ?>/admin/assets/plugins/simplelightbox/simple-lightbox.min.css">

<script src="<?php echo SITE_URL; ?>/admin/assets/plugins/sweetalert2/sweetalert2.min.js"></script>

<?php if (isset($additionalScripts) && is_array($additionalScripts)): ?>
<!-- Page specific scripts -->
<?php foreach ($additionalScripts as $script): ?>
<script src="<?php echo SITE_URL; ?>/admin/<?php echo $script; ?>"></script>
<?php endforeach; ?>
<?php endif; ?>

<?php if (!$isLoginPage): ?>
<!-- Admin specific scripts -->
<script>
    // Dark mode toggle functionality
    $(function() {
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
        
        // Toast notification function
        window.showToast = function(message, type = 'info', duration = 5000) {
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
        };
        
        // Show flash messages from session
        <?php if (isset($_SESSION['alert_message']) && isset($_SESSION['alert_type'])): ?>
        showToast('<?php echo addslashes($_SESSION['alert_message']); ?>', '<?php echo $_SESSION['alert_type']; ?>');
        <?php unset($_SESSION['alert_message'], $_SESSION['alert_type']); ?>
        <?php endif; ?>
        
        // Loading indicator helper functions
        window.showLoadingIndicator = function(element) {
            $(element).addClass('position-relative').append(`
                <div class="overlay">
                    <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                </div>
            `);
        };
        
        window.hideLoadingIndicator = function(element) {
            $(element).removeClass('position-relative').find('.overlay').remove();
        };
        
        // Date formatter helper
        window.formatDate = function(dateString, format = 'long') {
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
        };
    });
</script>
<?php endif; ?>

<?php
// Include any page-specific scripts
if (isset($pageScripts) && is_array($pageScripts)):
    foreach ($pageScripts as $script):
        echo '<script src="' . htmlspecialchars($script) . '"></script>' . PHP_EOL;
    endforeach;
endif;
?>

<!-- Main Footer -->
<footer class="main-footer">
    <div class="float-right d-none d-sm-block">
        <b>Versione</b> <?php echo APP_VERSION; ?>
    </div>
    <strong>Copyright &copy; <?php echo date('Y'); ?> <a href="<?php echo SITE_URL; ?>">Banda Folk di Castello Tesino</a>.</strong> Tutti i diritti riservati.
</footer>
</body>
</html>
