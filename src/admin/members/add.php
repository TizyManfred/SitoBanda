<?php
/**
 * Admin Member Add Redirect
 *
 * Redirects to the edit form with action=add
 * Following PSR-12 coding standards
 */

// Define ABSPATH for security
define('ABSPATH', dirname(dirname(__DIR__)) . '/');

// Redirect to edit form with add action
header('Location: edit.php');
exit;
?>
