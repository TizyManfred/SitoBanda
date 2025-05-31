<?php
/**
 * Admin Logout
 *
 * Handles the logout process for the admin area
 * Following PSR-12 coding standards and security best practices
 */

// Define ABSPATH for security
define('ABSPATH', dirname(__DIR__) . '/');

// Include configuration and authentication
require_once ABSPATH . 'includes/config.php';
require_once ABSPATH . 'includes/auth.php';

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Log the user out
Auth::logout();

// Redirect to login page
header('Location: login.php');
exit;
?>
