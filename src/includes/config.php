<?php
/**
 * Configuration File
 *
 * Main configuration settings for SitoBanda website
 * Following PSR-12 coding standards
 *
 * @author   SitoBanda Team
 * @version  1.0.0
 */

// Prevent direct access to this file
if (!defined('ABSPATH')) {
    define('ABSPATH', dirname(__DIR__) . '/');
}

// Basic site settings
define('SITE_URL', 'http://localhost:11001');  // Change in production
define('SITE_NAME', 'Banda Folk di Castello Tesino');
define('SITE_EMAIL', 'info@bandafolkcastellotesino.it');
define('SITE_PHONE', '+39 340 123 4567');

// Database settings (if using MySQL)
define('DB_HOST', 'localhost');
define('DB_NAME', 'sitobanda');
define('DB_USER', 'root');           // Change in production
define('DB_PASSWORD', '');           // Change in production
define('DB_CHARSET', 'utf8mb4');
define('DB_COLLATE', 'utf8mb4_unicode_ci');

// Email settings
define('SMTP_HOST', 'smtp.example.com');     // Change in production
define('SMTP_PORT', 587);
define('SMTP_USERNAME', 'username');         // Change in production
define('SMTP_PASSWORD', 'password');         // Change in production
define('SMTP_SECURE', 'tls');
define('SMTP_FROM_EMAIL', SITE_EMAIL);
define('SMTP_FROM_NAME', SITE_NAME);

// ReCaptcha settings (for forms)
define('RECAPTCHA_SITE_KEY', '');            // Add your key in production
define('RECAPTCHA_SECRET_KEY', '');          // Add your key in production

// Social media links
define('SOCIAL_FACEBOOK', 'https://www.facebook.com/');  // Add actual URL
define('SOCIAL_INSTAGRAM', 'https://www.instagram.com/'); // Add actual URL
define('SOCIAL_YOUTUBE', 'https://www.youtube.com/');     // Add actual URL

// File paths
define('TEMPLATES_PATH', ABSPATH . 'templates/');
define('UPLOADS_PATH', ABSPATH . 'public/uploads/');
define('LOGS_PATH', ABSPATH . 'logs/');

// Error reporting settings
// Development
if ($_SERVER['SERVER_NAME'] === 'localhost' || $_SERVER['SERVER_ADDR'] === '127.0.0.1') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    define('ENVIRONMENT', 'development');
} else {
    // Production
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT);
    define('ENVIRONMENT', 'production');
}

// Timezone settings
date_default_timezone_set('Europe/Rome');

// Session configuration
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', ENVIRONMENT === 'production' ? 1 : 0);
session_start();

// Include additional configuration files
$additionalConfigFiles = [
    'database.php',
    'routes.php',
    'mailer.php'
];

foreach ($additionalConfigFiles as $configFile) {
    $configFilePath = ABSPATH . 'includes/' . $configFile;
    if (file_exists($configFilePath)) {
        require_once $configFilePath;
    }
}
