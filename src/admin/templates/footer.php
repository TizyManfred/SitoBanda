<?php
/**
 * Admin Footer Template
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
            </main>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- Toast Container for Notifications -->
    <div class="toast-container"></div>

    <!-- Footer -->
    <footer class="footer mt-auto py-3 bg-light">
        <div class="container text-center">
            <span class="text-muted">
                &copy; <?php echo date('Y'); ?> Banda Folk di Castello Tesino. Tutti i diritti riservati.
                <span class="d-none d-sm-inline-block">|</span>
                <span class="d-block d-sm-inline-block">
                    Versione <?php echo htmlspecialchars(SITE_VERSION); ?>
                </span>
            </span>
        </div>
    </footer>

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <?php if (!$isLoginPage): ?>
    <!-- Admin specific scripts -->
    <script src="assets/js/admin.js"></script>
    
    <!-- Charts if needed -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
    
    <script>
        // Initialize tooltips
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
            
            // Task checkboxes
            $('.custom-checkbox input[type="checkbox"]').change(function() {
                var label = $(this).next('label');
                if ($(this).is(':checked')) {
                    label.html('<s>' + label.text() + '</s>');
                } else {
                    label.html(label.text());
                }
            });
            
            // Dynamic year in copyright
            const year = new Date().getFullYear();
            document.getElementById('current-year').innerHTML = year;
            
            // Toggle sidebar on mobile
            $('#sidebarToggle').on('click', function() {
                $('.sidebar').toggleClass('toggled');
            });
            
            // Close sidebar when clicking outside on mobile
            $(document).on('click', function(e) {
                if (window.innerWidth < 768) {
                    if (!$(e.target).closest('.sidebar, #sidebarToggle').length) {
                        $('.sidebar').removeClass('toggled');
                    }
                }
            });
            
            // Handle modal form submission
            $('#taskForm').on('submit', function(e) {
                e.preventDefault();
                // In a real app, you would submit via AJAX here
                $('#addTaskModal').modal('hide');
                
                // Show success toast
                showToast('Promemoria aggiunto con successo!', 'success');
                
                // Reset form
                this.reset();
            });
            
            // Submit form when clicking the save button
            $('#addTaskModal .btn-primary').on('click', function() {
                $('#taskForm').submit();
            });
        });
        
        // Toast notification function
        function showToast(message, type = 'info') {
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
        }
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
</body>
</html>
